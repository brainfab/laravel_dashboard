<?php
namespace Vendor\Admin;

use StringTools;
use ModelStructure;
use sfYaml;
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use \Illuminate\Support\Facades\File;

class AdminGenController extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'admin:gen_controller';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Generate admin controller and structure file.';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{
		$model = $this->argument('model_name');
        if(empty($model) || !class_exists($model)) {
            $this->error('Model not exists');
        }

        $controller_tpl =
'<?php
/**
 * @date: '.date('d.m.Y H:i:s').'
 */
class __MODULE__Controller extends __TYPE__Controller{

}
';

        $path = __DIR__ . '/../controllers/modules/'.StringTools::directorize(StringTools::pluralize($model)).'/';
        if(!is_dir($path)) {
            File::makeDirectory($path, 755);
        }
        $s = ModelStructure::getStructure($model);
        $pk = $s['primary_key'];
        $fields = array();
        foreach ($s['columns'] as $column => $params) {
            $field = array(
                'title' => StringTools::functionalize($column)
            );
            if ($column == $pk){
                $field['readonly'] = true;
            }
            if (strpos($params['type'],'tinyint') !== false) {
                $field['type'] = 'checkbox';
            } elseif (strpos($params['type'],'enum') !== false) {
                $field['type'] = 'radioselect';
            } elseif (strpos($params['type'],'text') !== false) {
                $field['type'] = 'area';
            } elseif (strpos($params['type'],'date') !== false) {
                $field['type'] = 'datepicker';
                if (strpos($params['type'],'time') !== false) {
                    $field['timepicker'] = true;
                }
            } else {
                $field['type'] = 'text';
            }
            $fields[$column] = $field;
        }

        $module_title = StringTools::functionalize($model);
        $type = 'List';
        $data = array(
            'title' => $module_title,
            'single'=> StringTools::singularize($module_title),
            'model' => $model,
            'fields'=> $fields,
            'sort'  => $pk.' ASC',
            'tabs'  => array(),
            'actions' => array(
                'list' => array(),
                'delete' => true,
                'edit' => array('hide'=>array($pk)),
                'add'  => array('hide'=>array($pk)),
            )
        );
        $structure_path = $path . StringTools::directorize(StringTools::pluralize($model)).'.yml';
        if(!is_file($structure_path)) {
            File::put($structure_path, sfYaml::dump($data, 6));
        }

        //add to menu
        $menu_file_path = __DIR__ . '/../config/menu.yml';
        if (is_file($menu_file_path)) {
            $menu = sfYaml::load($menu_file_path);
        } else {
            $menu = array();
        }
        $module_title = StringTools::pluralize($model);
        $module_name = StringTools::directorize(StringTools::pluralize($model));
        if (!isset($menu[$module_name])) {
            $menu[$module_name] = array(
                'title' => $module_title
            );
            File::put($menu_file_path,sfYaml::dump($menu, 6));
        }

        //create controller
        $controllers_path = $path . StringTools::pluralize($model) .'Controller.class.php';
        $sketelon = str_replace(array('__MODULE__','__TYPE__'),array(StringTools::pluralize($model), $type), $controller_tpl);
        if(!is_file($controllers_path)) {
            File::put($controllers_path, $sketelon);
        }
        $this->info('Controller for '.$model .' was successful added');
        $this->info('Start dump-autoload...');
        $this->call('dump-autoload');
	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return array(
			array('model_name', InputArgument::REQUIRED, 'Model name.'),
		);
	}

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	protected function getOptions()
	{
		return array(
//			array('example', null, InputOption::VALUE_OPTIONAL, 'An example option.', null),
		);
	}

}
