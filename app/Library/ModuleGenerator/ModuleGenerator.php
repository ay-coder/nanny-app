<?php namespace App\Library\ModuleGenerator;

use File;
use Schema;

/**
 * Class Module Generator
 *
 * @author Anuj Jaha
 */


class ModuleGenerator
{
    protected $moduleName;

    protected $routePath        = 'routes/Backend';
    protected $modelPath        = 'app/Models';
    protected $controllerPath           = 'app/Http/Controllers/Backend';
    protected $eloquentPath             = 'app/Repositories';
    protected $viewPath                 = 'resources/views';

    public $createModuleViewFilePath;
    public $commonModuleViewFilePath;
    protected $createModuleViewFiles    = [
        'create.blade.php',
        'edit.blade.php',
        'index.blade.php'
    ];

    protected $commonModuleViewFiles = [
        'form.blade.php',
        'header-buttons.blade.php'
    ];

    protected $tableName;

    public function __construct($moduleName)
    {
        $this->moduleName   = ucfirst($moduleName);
        $this->tableName    = 'data_table_name';
        $this->createModuleViewFilePath = storage_path() . DIRECTORY_SEPARATOR . 'commonview' . DIRECTORY_SEPARATOR . 'module-view';
        $this->commonModuleViewFilePath = storage_path() . DIRECTORY_SEPARATOR . 'commonview' . DIRECTORY_SEPARATOR . 'common-view';
    }

    public function getTableName()
    {
        return $this->tableName;
    }

    public function setTableName($name = null)
    {
        $this->tableName = isset($name) ? $name : 'data_table_name';
        return $this;
    }

    public function generateRoute()
    {
        $routePath  = base_path() . DIRECTORY_SEPARATOR . $this->routePath;
        $fileName   = $this->moduleName.'.php';
        $file       = $routePath . DIRECTORY_SEPARATOR . $fileName;
        $content    = $this->getRouteTemplate($this->moduleName);

        if(! is_writable($routePath))
        {
            // Change Folder Permission
            chmod($routePath, 0755);
        }

        $status = File::put($file, $content);

        if($status)
        {
            chmod($file, 0777);
            return true;
        }

        return false;
    }

    public function generateModel()
    {
        $modelPath  = base_path() . DIRECTORY_SEPARATOR . $this->modelPath;
        $fileName   = $this->moduleName.'.php';

        if(! is_dir($modelPath.DIRECTORY_SEPARATOR.$this->moduleName))
        {
            mkdir($modelPath.DIRECTORY_SEPARATOR.$this->moduleName, 0777, true);
        }

        $filePath   = $modelPath.DIRECTORY_SEPARATOR.$this->moduleName;
        $file       = $filePath . DIRECTORY_SEPARATOR . $fileName;
        $content    = $this->getModelTemplate($this->moduleName);
        $status     = $this->generateContent($filePath, $file, $content);

        if($status)
        {
            $this->generateModelRelationship($filePath);
            $this->generateModelAttribute($filePath);
        }

        return $status;
    }

    public function generateModuleView()
    {
        $viewPath           =  base_path() . DIRECTORY_SEPARATOR . $this->viewPath;
        $backendPath        = $viewPath. DIRECTORY_SEPARATOR . 'backend';
        $commonPath         = $viewPath. DIRECTORY_SEPARATOR . 'common';
        $baseBackendPath    = $backendPath .  DIRECTORY_SEPARATOR . strtolower($this->moduleName);
        $baseCommonPath     = $commonPath .  DIRECTORY_SEPARATOR . strtolower($this->moduleName);

        if(! is_dir($baseBackendPath))
        {
            mkdir($baseBackendPath, 0777, true);
        }

        if(! is_dir($baseCommonPath))
        {
            mkdir($baseCommonPath, 0777, true);
        }

        foreach($this->createModuleViewFiles as $viewFile)
        {
            copy($this->createModuleViewFilePath . DIRECTORY_SEPARATOR . $viewFile , $baseBackendPath . DIRECTORY_SEPARATOR . $viewFile);
            chmod($baseBackendPath . DIRECTORY_SEPARATOR . $viewFile, 0777);
        }

        foreach($this->commonModuleViewFiles as $viewFile)
        {
            copy($this->commonModuleViewFilePath . DIRECTORY_SEPARATOR . $viewFile , $baseCommonPath . DIRECTORY_SEPARATOR . $viewFile);
            chmod($baseCommonPath . DIRECTORY_SEPARATOR . $viewFile, 0777);
        }

        return true;
    }

    public function generateModelRelationship($filepath)
    {
        $basePath = $filepath .  DIRECTORY_SEPARATOR . 'Traits' . DIRECTORY_SEPARATOR . 'Relationship';

        if(! is_dir($basePath))
        {
            mkdir($basePath, 0777, true);
        }

        $file       = $basePath . DIRECTORY_SEPARATOR . 'Relationship.php';
        $content    = $this->getRelationshipContent();

        return $this->generateContent($basePath, $file, $content);
    }

    public function generateModelAttribute($filepath)
    {
        $basePath = $filepath .  DIRECTORY_SEPARATOR . 'Traits' . DIRECTORY_SEPARATOR . 'Attribute';

        if(! is_dir($basePath))
        {
            mkdir($basePath, 0777, true);
        }

        $file       = $basePath . DIRECTORY_SEPARATOR . 'Attribute.php';
        $content    = $this->getModelAttributeContent();

        return $this->generateContent($basePath, $file, $content);
    }

    public function generateContent($filePath, $file, $content)
    {
        if(! is_writable($filePath))
        {
            // Change Folder Permission
            chmod($filePath, 0755);
        }

        $status = File::put($file, $content);

        if($status)
        {
            chmod($file, 0777);
            return true;
        }

        return false;
    }

    public function generateController()
    {
        $basePath   = base_path() . DIRECTORY_SEPARATOR . $this->controllerPath;
        $fileName   = "Admin" . $this->moduleName . 'Controller.php';

        if(! is_dir($basePath.DIRECTORY_SEPARATOR.$this->moduleName))
        {
            mkdir($basePath.DIRECTORY_SEPARATOR.$this->moduleName, 0777, true);
        }

        $filePath   = $basePath.DIRECTORY_SEPARATOR.$this->moduleName;
        $file       = $filePath . DIRECTORY_SEPARATOR . $fileName;
        $content    = $this->getControllerTemplate($this->moduleName);

        if(! is_writable($filePath))
        {
            // Change Folder Permission
            chmod($filePath, 0755);
        }

        $status = File::put($file, $content);

        if($status)
        {
            chmod($file, 0777);
            return true;
        }

        return false;
    }

    public function generateEloquent()
    {
        $basePath   = base_path() . DIRECTORY_SEPARATOR . $this->eloquentPath;
        $fileName   = 'Eloquent' . $this->moduleName . 'Repository.php';

        if(! is_dir($basePath.DIRECTORY_SEPARATOR.$this->moduleName))
        {
            mkdir($basePath.DIRECTORY_SEPARATOR.$this->moduleName, 0777, true);
        }

        $filePath   = $basePath.DIRECTORY_SEPARATOR.$this->moduleName;
        $file       = $filePath . DIRECTORY_SEPARATOR . $fileName;
        $content    = $this->getEloquentTemplate($this->moduleName);

        if(! is_writable($filePath))
        {
            // Change Folder Permission
            chmod($filePath, 0755);
        }

        $status = File::put($file, $content);

        if($status)
        {
            chmod($file, 0777);
            return true;
        }

        return false;
    }

    public function generateViews()
    {

    }

    public function getRelationshipContent($moduleName = null)
    {
        $moduleName         = isset($moduleName) ? $moduleName : $this->moduleName;
        $keyword            = '###MODULE-NAME###';
        $change             = $moduleName;
        $html               = <<<EOD
<?php namespace App\Models\###MODULE-NAME###\Traits\Relationship;

trait Relationship
{
}
EOD;
        return str_replace($keyword, $change, $html);
    }

    public function getModelAttributeContent($moduleName = null)
    {
        $moduleName         = isset($moduleName) ? $moduleName : $this->moduleName;
        $moduleRoutePrefix  = strtolower($moduleName);
        $keyword            = '###MODULE-NAME###';
        $change             = $moduleName;
        $html               = <<<EOD
<?php namespace App\Models\###MODULE-NAME###\Traits\Attribute;

/**
 * Trait Attribute
 *
 * @author Anuj Jaha ( er.anujjaha@gmail.com )
 */

use App\Repositories\###MODULE-NAME###\Eloquent###MODULE-NAME###Repository;

trait Attribute
{
    /**
     * @return string
     */
    public function getEditButtonAttribute(##$##routes, ##$##prefix = 'admin', ##$##isAdmin = false)
    {
        ##$##id = ##$##isAdmin ? ##$##this->id : hasher()->encode(##$##this->id);

        return '<a href="'.route(##$##prefix .'.'. ##$##routes->editRoute, ##$##id).'" class="btn btn-xs btn-primary"><i class="fa fa-pencil" data-toggle="tooltip" data-placement="top" title="Edit"></i></a> ';
    }

    /**
     * @return string
     */
    public function getDeleteButtonAttribute(##$##routes, ##$##prefix = 'admin')
    {
        return '<a href="'.route(##$##prefix .'.'. ##$##routes->deleteRoute, ##$##this).'"
                data-method="delete"
                data-trans-button-cancel="Cancel"
                data-trans-button-confirm="Delete"
                data-trans-title="Do you want to Delete this Item ?"
                class="btn btn-xs btn-danger"><i class="fa fa-times" data-toggle="tooltip" data-placement="top" title="Delete"></i></a>';
    }

    /**
     * @return string
     */
    public function getActionButtonsAttribute()
    {
        ##$##repository = new Eloquent###MODULE-NAME###Repository;
        ##$##routes     = ##$##repository->getModuleRoutes();

        return ##$##this->getEditButtonAttribute(##$##routes, ##$##repository->clientRoutePrefix) . ##$##this->getDeleteButtonAttribute(##$##routes, ##$##repository->clientRoutePrefix);
    }

    /**
     * @return string
     */
    public function getAdminActionButtonsAttribute()
    {
        ##$##repository = new Eloquent###MODULE-NAME###Repository;
        ##$##routes     = ##$##repository->getModuleRoutes();

        return ##$##this->getEditButtonAttribute(##$##routes, ##$##repository->adminRoutePrefix, true) . ##$##this->getDeleteButtonAttribute(##$##routes, ##$##repository->adminRoutePrefix);
    }
}
EOD;
        $html = str_replace("##$##", '$', $html);
        return str_replace($keyword, $change, $html);
    }

    public function getRouteTemplate($moduleName = null)
    {
        $moduleName         = isset($moduleName) ? $moduleName : $this->moduleName;
        $moduleRoutePrefix  = strtolower($moduleName);
        $keyword            = '###MODULE-NAME###';
        $change             = $moduleName;
        $html               = <<<EOD
<?php

Route::group([
    "namespace"  => "###MODULE-NAME###",
], function () {
    /*
     * Admin ###MODULE-NAME### Controller
     */

    // Route for Ajax DataTable
    Route::get("$moduleRoutePrefix/get", "Admin###MODULE-NAME###Controller@getTableData")->name("$moduleRoutePrefix.get-list-data");

    Route::resource("$moduleRoutePrefix", "Admin###MODULE-NAME###Controller");
});
EOD;
        return str_replace($keyword, $change, $html);
    }

    public function getModelTemplate($moduleName = null, $tableName = null)
    {
        $moduleName         = isset($moduleName) ? $moduleName : $this->moduleName;
        $tableName          = isset($tableName) ? $tableName : $this->tableName;
        $moduleRoutePrefix  = strtolower($moduleName);
        $keyword            = '###MODULE-NAME###';
        $tableKey           = "###TABLE-NAME###";
        $timeStamp          = "###TABLE-TIMESTAMP###";
        $change             = $moduleName;
        $html               = <<<EOD
<?php namespace App\Models\###MODULE-NAME###;

/**
 * Class ###MODULE-NAME###
 *
 * @author Anuj Jaha ( er.anujjaha@gmail.com)
 */

use App\Models\BaseModel;
use App\Models\###MODULE-NAME###\Traits\Attribute\Attribute;
use App\Models\###MODULE-NAME###\Traits\Relationship\Relationship;

class ###MODULE-NAME### extends BaseModel
{
    use Attribute, Relationship;
    /**
     * Database Table
     *
     */
    protected ##$##table = "###TABLE-NAME###";

    /**
     * Fillable Database Fields
     *
     */
    protected ##$##fillable = [
        'id',
    ];

    /**
     * Timestamp flag
     *
     */
    public ##$##timestamps = ###TABLE-TIMESTAMP###;

    /**
     * Guarded ID Column
     *
     */
    protected ##$##guarded = ["id"];
}
EOD;

        // Check Table Schema
        $columns = Schema::getColumnListing($tableName);

        // Set Timestamp Flag
        if(in_array('created_at', $columns) && in_array('updated_at', $columns))
        {
            $html = str_replace("###TABLE-TIMESTAMP###", 'true', $html);
        }
        else
        {
            $html = str_replace("###TABLE-TIMESTAMP###", 'false', $html);
        }

        $html = str_replace("##$##", '$', $html);
        $html = str_replace($tableKey, $tableName, $html);
        return str_replace($keyword, $change, $html);
    }

    public function getControllerTemplate($moduleName = null, $tableName = null)
    {
        $moduleName         = isset($moduleName) ? $moduleName : $this->moduleName;
        $moduleRoutePrefix  = strtolower($moduleName);
        $keyword            = '###MODULE-NAME###';
        $change             = $moduleName;
        $html               = <<<EOD
<?php namespace App\Http\Controllers\Backend\###MODULE-NAME###;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\Datatables\Facades\Datatables;
use App\Repositories\###MODULE-NAME###\Eloquent###MODULE-NAME###Repository;

/**
 * Class Admin###MODULE-NAME###Controller
 */
class Admin###MODULE-NAME###Controller extends Controller
{
    /**
     * ###MODULE-NAME### Repository
     *
     * @var object
     */
    public ##$##repository;

    /**
     * Create Success Message
     *
     * @var string
     */
    protected ##$##createSuccessMessage = "###MODULE-NAME### Created Successfully!";

    /**
     * Edit Success Message
     *
     * @var string
     */
    protected ##$##editSuccessMessage = "###MODULE-NAME### Edited Successfully!";

    /**
     * Delete Success Message
     *
     * @var string
     */
    protected ##$##deleteSuccessMessage = "###MODULE-NAME### Deleted Successfully";

    /**
     * __construct
     *
     */
    public function __construct()
    {
        ##$##this->repository = new Eloquent###MODULE-NAME###Repository;
    }

    /**
     * ###MODULE-NAME### Listing
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view(##$##this->repository->setAdmin(true)->getModuleView('listView'))->with([
            'repository' => ##$##this->repository
        ]);
    }

    /**
     * ###MODULE-NAME### View
     *
     * @return \Illuminate\View\View
     */
    public function create(Request ##$##request)
    {
        return view(##$##this->repository->setAdmin(true)->getModuleView('createView'))->with([
            'repository' => ##$##this->repository
        ]);
    }

    /**
     * ###MODULE-NAME### Store
     *
     * @return \Illuminate\View\View
     */
    public function store(Request ##$##request)
    {
        ##$##this->repository->create(##$##request->all());

        return redirect()->route(##$##this->repository->setAdmin(true)->getActionRoute('listRoute'))->withFlashSuccess(##$##this->createSuccessMessage);
    }

    /**
     * ###MODULE-NAME### Edit
     *
     * @return \Illuminate\View\View
     */
    public function edit(##$##id, Request ##$##request)
    {
        ##$##item = ##$##this->repository->findOrThrowException(##$##id);

        return view(##$##this->repository->setAdmin(true)->getModuleView('editView'))->with([
            'item'          => ##$##item,
            'repository'    => ##$##this->repository
        ]);
    }

    /**
     * ###MODULE-NAME### Show
     *
     * @return \Illuminate\View\View
     */
    public function show(##$##id, Request ##$##request)
    {
        ##$##item = ##$##this->repository->findOrThrowException(##$##id);

        return view(##$##this->repository->setAdmin(true)->getModuleView('editView'))->with([
            'item'          => ##$##item,
            'repository'    => ##$##this->repository
        ]);
    }


    /**
     * ###MODULE-NAME### Update
     *
     * @return \Illuminate\View\View
     */
    public function update(##$##id, Request ##$##request)
    {
        ##$##status = ##$##this->repository->update(##$##id, ##$##request->all());

        return redirect()->route(##$##this->repository->setAdmin(true)->getActionRoute('listRoute'))->withFlashSuccess(##$##this->editSuccessMessage);
    }

    /**
     * ###MODULE-NAME### Destroy
     *
     * @return \Illuminate\View\View
     */
    public function destroy(##$##id)
    {
        ##$##status = ##$##this->repository->destroy(##$##id);

        return redirect()->route(##$##this->repository->setAdmin(true)->getActionRoute('listRoute'))->withFlashSuccess(##$##this->deleteSuccessMessage);
    }

    /**
     * Get Table Data
     *
     * @return json|mixed
     */
    public function getTableData()
    {
        return Datatables::of(##$##this->repository->getForDataTable())
            ->escapeColumns(['id', 'sort'])
            ->addColumn('actions', function (##$##item) {
                return ##$##item->admin_action_buttons;
            })
            ->make(true);
    }
}
EOD;
        $html = str_replace("##$##", '$', $html);
        return str_replace($keyword, $change, $html);
    }

    public function getEloquentTemplate($moduleName = null)
    {
        $moduleName         = isset($moduleName) ? $moduleName : $this->moduleName;
        $moduleRoutePrefix  = strtolower($moduleName);
        $keyword            = '###MODULE-NAME###';
        $change             = $moduleName;
        $html               = <<<EOD
<?php namespace App\Repositories\###MODULE-NAME###;

/**
 * Class Eloquent###MODULE-NAME###Repository
 *
 * @author Anuj Jaha ( er.anujjaha@gmail.com)
 */

use App\Models\###MODULE-NAME###\###MODULE-NAME###;
use App\Repositories\DbRepository;
use App\Exceptions\GeneralException;

class Eloquent###MODULE-NAME###Repository extends DbRepository
{
    /**
     * ###MODULE-NAME### Model
     *
     * @var Object
     */
    public ##$##model;

    /**
     * ###MODULE-NAME### Title
     *
     * @var string
     */
    public ##$##moduleTitle = '###MODULE-NAME###';

    /**
     * Table Headers
     *
     * @var array
     */
    public ##$##tableHeaders = [
        'id'        => 'Id',
        'actions'   => 'Actions'
    ];

    /**
     * Table Columns
     *
     * @var array
     */
    public ##$##tableColumns = [
        'id' =>   [
            'data'          => 'id',
            'name'          => 'id',
            'searchable'    => true,
            'sortable'      => true
        ],
        'actions' => [
            'data'          => 'actions',
            'name'          => 'actions',
            'searchable'    => false,
            'sortable'      => false
        ]
    ];

    /**
     * Is Admin
     *
     * @var boolean
     */
    protected ##$##isAdmin = false;

    /**
     * Admin Route Prefix
     *
     * @var string
     */
    public ##$##adminRoutePrefix = 'admin';

    /**
     * Client Route Prefix
     *
     * @var string
     */
    public ##$##clientRoutePrefix = 'frontend';

    /**
     * Admin View Prefix
     *
     * @var string
     */
    public ##$##adminViewPrefix = 'backend';

    /**
     * Client View Prefix
     *
     * @var string
     */
    public ##$##clientViewPrefix = 'frontend';

    /**
     * Module Routes
     *
     * @var array
     */
    public ##$##moduleRoutes = [
        'listRoute'     => '###LOWER-CASEMODULE-NAME###.index',
        'createRoute'   => '###LOWER-CASEMODULE-NAME###.create',
        'storeRoute'    => '###LOWER-CASEMODULE-NAME###.store',
        'editRoute'     => '###LOWER-CASEMODULE-NAME###.edit',
        'updateRoute'   => '###LOWER-CASEMODULE-NAME###.update',
        'deleteRoute'   => '###LOWER-CASEMODULE-NAME###.destroy',
        'dataRoute'     => '###LOWER-CASEMODULE-NAME###.get-list-data'
    ];

    /**
     * Module Views
     *
     * @var array
     */
    public ##$##moduleViews = [
        'listView'      => '###LOWER-CASEMODULE-NAME###.index',
        'createView'    => '###LOWER-CASEMODULE-NAME###.create',
        'editView'      => '###LOWER-CASEMODULE-NAME###.edit',
        'deleteView'    => '###LOWER-CASEMODULE-NAME###.destroy',
    ];

    /**
     * Construct
     *
     */
    public function __construct()
    {
        ##$##this->model = new ###MODULE-NAME###;
    }

    /**
     * Create ###MODULE-NAME###
     *
     * @param array ##$##input
     * @return mixed
     */
    public function create(##$##input)
    {
        ##$##input = ##$##this->prepareInputData(##$##input, true);
        ##$##model = ##$##this->model->create(##$##input);

        if(##$##model)
        {
            return ##$##model;
        }

        return false;
    }

    /**
     * Update ###MODULE-NAME###
     *
     * @param int ##$##id
     * @param array ##$##input
     * @return bool|int|mixed
     */
    public function update(##$##id, ##$##input)
    {
        ##$##model = ##$##this->model->find(##$##id);

        if(##$##model)
        {
            ##$##input = ##$##this->prepareInputData(##$##input);

            return ##$##model->update(##$##input);
        }

        return false;
    }

    /**
     * Destroy ###MODULE-NAME###
     *
     * @param int ##$##id
     * @return mixed
     * @throws GeneralException
     */
    public function destroy(##$##id)
    {
        ##$##model = ##$##this->model->find(##$##id);

        if(##$##model)
        {
            return ##$##model->delete();
        }

        return  false;
    }

    /**
     * Get All
     *
     * @param string ##$##orderBy
     * @param string ##$##sort
     * @return mixed
     */
    public function getAll(##$##orderBy = 'id', ##$##sort = 'asc')
    {
        return ##$##this->model->all();
    }

    /**
     * Get by Id
     *
     * @param int ##$##id
     * @return mixed
     */
    public function getById(##$##id = null)
    {
        if(##$##id)
        {
            return ##$##this->model->find(##$##id);
        }

        return false;
    }

    /**
     * Get Table Fields
     *
     * @return array
     */
    public function getTableFields()
    {
        return [
            ##$##this->model->getTable().'.id as id'
        ];
    }

    /**
     * @return mixed
     */
    public function getForDataTable()
    {
        return ##$##this->model->select(##$##this->getTableFields())->get();
    }

    /**
     * Set Admin
     *
     * @param boolean ##$##isAdmin [description]
     */
    public function setAdmin(##$##isAdmin = false)
    {
        ##$##this->isAdmin = ##$##isAdmin;

        return ##$##this;
    }

    /**
     * Prepare Input Data
     *
     * @param array ##$##input
     * @param bool ##$##isCreate
     * @return array
     */
    public function prepareInputData(##$##input = array(), ##$##isCreate = false)
    {
        if(##$##isCreate)
        {
            ##$##input = array_merge(##$##input, ['user_id' => access()->user()->id]);
        }

        return ##$##input;
    }

    /**
     * Get Table Headers
     *
     * @return string
     */
    public function getTableHeaders()
    {
        if(##$##this->isAdmin)
        {
            return json_encode(##$##this->setTableStructure(##$##this->tableHeaders));
        }

        ##$##clientHeaders = ##$##this->tableHeaders;

        unset(##$##clientHeaders['username']);

        return json_encode(##$##this->setTableStructure(##$##clientHeaders));
    }

    /**
     * Get Table Columns
     *
     * @return string
     */
    public function getTableColumns()
    {
        if(##$##this->isAdmin)
        {
            return json_encode(##$##this->setTableStructure(##$##this->tableColumns));
        }

        ##$##clientColumns = ##$##this->tableColumns;

        unset(##$##clientColumns['username']);

        return json_encode(##$##this->setTableStructure(##$##clientColumns));
    }
}
EOD;
        $html = str_replace("###LOWER-CASEMODULE-NAME###", strtolower($moduleName), $html);
        $html = str_replace("##$##", '$', $html);
        return str_replace($keyword, $change, $html);
    }
}