<?php

declare(strict_types=1);

namespace App\Orchid\Screens;

use Orchid\Screen\Screen;
use Orchid\Support\Color;
use App\Models\Assessment\RMSD;
use Orchid\Screen\Fields\Label;
use App\Models\Assessment\Threat;
use Orchid\Support\Facades\Alert;
use Orchid\Support\Facades\Layout;
use App\Models\Assessment\Treatment;
use App\Models\Assessment\Valuation;
use Illuminate\Support\Facades\Auth;
use App\Models\Assessment\Protection;
use App\Models\Management\TeamMember;
use Orchid\Screen\Actions\ModalToggle;
use App\Models\Management\SimsManagement;
use App\Models\Management\AssetManagement;
use App\Orchid\Layouts\Dashboard\TreatmentChart;
use App\Orchid\Layouts\Dashboard\AssetTypeChart;
use App\Orchid\Layouts\Dashboard\RiskLevelChart;
use Orchid\Screen\Actions\Button;

class PlatformScreen extends Screen
{
    public $logout = null;
    public $user;
    public $asset;
    public $threat;
    public $rmsd;
    public $sims;
    public $team;
    public $protection;
    public $treatment;
    public $valuation;
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query($logout = null): iterable
    {
        if(is_null($logout)){
            $logout = null;
        }
        $this->logout = $logout;

        $this->user = Auth::user();

        $this->asset = AssetManagement::all();
        $this->sims = SimsManagement::all();
        $this->team = TeamMember::all();

        $this->valuation = Valuation::all();       
        $this->threat = Threat::all();
        $this->rmsd = RMSD::all();

        $this->protection = Protection::all();
        $this->treatment = Treatment::all();   



        return [

        


        'asset_chart'  => [
            [
                
                'values' => [$this->asset->where('type', 'Hardware')->count(),
                             $this->asset->where('type', 'Software')->count(),
                             $this->asset->where('type', 'Data and Information')->count(),
                             $this->asset->where('type', 'Human Resources')->count(),
                             $this->asset->where('type', 'Services')->count(),
                             $this->asset->where('type', 'Work Process')->count(),
                             $this->asset->where('type', 'Premise')->count(),
                            ],
                'labels' => ['Hardware','Software','Data and Information','Human Resources','Services','Work Process','Premise'],
                
            ],
           
        ],

        'risk_chart'  => [
            [
                
                'values' => [   $this->rmsd->where('risk_level', 'Low')->count(),
                                $this->rmsd->where('risk_level', 'Medium')->count(),
                                $this->rmsd->where('risk_level', 'High')->count(),
                            ],
                'labels' => ['Low','Medium','High'],
            ],
           
        ],

        'treatment_chart'   => [
            [
                
                'values' => [   $this->protection->where('decision', 'Reduce')->count(),
                                $this->protection->where('decision', 'Accept')->count(),
                            ],
                'labels' => ['Yes','No'],
            ],
           
        ],
        'metrics' => [
            'assets'    => ['value' => $this->asset->count()],
            'threat' => ['value' => $this->threat->count()],
            'RA'   => ['value' => $this->threat->where('status', 'Draft')->count()],
            'team'    => ['value' => $this->team->count()],
        ],
    
    
        ];


        
    }

    /**
     * The name of the screen displayed in the header.
     */
    public function name(): ?string
    {
        return 'SIMS Risk Assessment Platform';
    }

    /**
     * Display header description.
     */
    public function description(): ?string{
        return 'Welcome to the SIMS Risk Assessment Platform. This platform is designed to help you assess the risk of your organization. ' ;
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            ModalToggle::make('Log Out')
                ->icon('bs.box-arrow-right')
                ->modal('logOut')
                ->method('logOut')
                ->style('font-size:13px;')
                ->open($this->logout === 'true'),
        ];
    }

    /**
     * The screen's layout elements.
     *
     * @return \Orchid\Screen\Layout[]
     */
    public function layout(): iterable
    {
        return [

            Layout::rows([

                Label::make('Welcome')
                    ->value('Welcome, ' . $this->user->name . '!')
                    ->help('You are logged in as ' . $this->user->email)
                    ->style('font-size:20px; margin:0; color: #000000;'),
                
                Button::make('Start Risk Assessment Wizard')
                    ->icon('bs.play')
                    ->method('start')
                    ->type(Color::INFO())

                
            ]),

            Layout::metrics2([
                'Asset Registered' => 'metrics.assets',
                'Current Threats' => 'metrics.threat',
                'Uncompleted RA' => 'metrics.RA',
                'Total Team Members' => 'metrics.team',
            ]),

            Layout::columns([

                RiskLevelChart::make('risk_chart', 'Risk Level Chart')
                ->description('The risk level charts in this project visually represent and categorize risks into different levels, such as low, medium, and high, based on real-time data. These charts help users quickly identify potential hazards and prioritize actions to manage risks effectively.'),

                TreatmentChart::make('treatment_chart', 'Risk Treatment Chart')
                ->description('The risk treatment charts display the actions taken to mitigate or manage identified risks. These charts help visualize the effectiveness of risk treatment strategies, showing the progress of risk reduction or control measures over time.'),
            ]),

            Layout::columns([

                AssetTypeChart::make('asset_chart', 'Asset Management Chart')
                    ->description('The asset management chart provides a visual overview of the status and value of various assets within the system. It helps track asset performance, maintenance schedules, and lifecycle stages, enabling users to make informed decisions on asset allocation and management.'),

            
            ]),         


       
                


            Layout::modal('logOut', Layout::rows([
                    Label::make('toast')
                    ->title('Alert:')
                    ->value('Are you sure you want to log out?')
                    ->style('font-style: italic; color: #6c757d;')
                ]))->title('Log Out Confirmation')->applyButton('Log Out'),

        ];
    }

    public function logOut()
    {
        // Perform the logout
        Auth::logout();

        // Redirect to the login screen
        Alert::info('You have been logged out.');
        return redirect()->route('platform.login');
    }

    public function start(){
        return redirect()->route('platform.management.AssetManagement');
    }
}
