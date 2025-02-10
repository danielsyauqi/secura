<?php

namespace App\Orchid\Screens\Report;

use App\Models\User;
use Orchid\Screen\Action;
use Orchid\Screen\Screen;
use Orchid\Support\Color;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Fields\Group;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Label;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Actions\Button;
use Orchid\Support\Facades\Toast;
use Orchid\Support\Facades\Layout;
use App\Models\Management\TeamMember;
use App\Orchid\Layouts\Management\MemberListLayout;

class PrintReport extends Screen
{


    public function query(): array
    {

        return [
            
        ];
    }

    public function name(): string
    {
        return 'Print Risk Assessment Report';
    }

    public function description(): string
    {
        return 'The SecuRA team is comprised of security, ICT, and business operations experts, ensuring that SecuRA, aligned with ISO 27001 standards, produces accurate risk assessments for organizational assets. 
        Each member brings specialized knowledge to manage security and operational risks effectively, allowing SecuRA to support comprehensive risk mitigation strategies while meeting ISO 27001 compliance.';
    }

    public function commandBar(): iterable
    {
        return [
           
        ];
    }

    public function layout(): iterable
    {
        return [
            Layout::rows([
                Label::make('Detail Risk Assessment Report')
                ->title('Detail Risk Assessment Report')
                ->help("The Detailed Risk Assessment Report evaluates the risks associated with various assets within the your organization, categorizing them by type and detailing key information such as asset identification, ownership, location, and valuation. 
                It assesses each asset's vulnerabilities and potential threats, along with the safeguards in place to mitigate those risks. The report further evaluates the business impact, including the likelihood and severity of risks, and determines the overall risk level for each asset based on its confidentiality, integrity, availability, and dependencies. The goal is to provide a comprehensive view of asset security and risk management, ensuring informed decision-making for risk treatment and safeguarding measures."),

                Group::make([
                    Link::make('Print Report (Scale 3)')
                    ->href(route('detailRA'))
                    ->style("width:35%")
                    ->icon('printer')
                    ->target('_blank')
                    ->type(Color::INFO()),

                    Link::make('Print Report (Scale 5)')
                    ->href(route('detailRA_5'))
                    ->style("width:35%")
                    ->icon('printer')
                    ->target('_blank')
                    ->type(Color::PRIMARY())
                ]),
                
        
            ]),

            
            Layout::rows([
                Label::make('Summary Report Appendix')
                ->title('Summary Report Appendix')
                ->help("The Risk Treatment Plan Summary Report provides a comprehensive overview of the strategies and actions taken to mitigate identified risks within an organization. This report is designed to help stakeholders understand the current status of risk treatments, including the specific actions implemented, the responsible parties, and the timelines for each treatment. By summarizing this information, the report aids in tracking progress, ensuring accountability, and facilitating informed decision-making regarding risk management efforts."),

                Group::make([

                    Link::make('Print Report (Scale 3)')
                    ->href(route('summary'))
                    ->style("width:35%")
                    ->icon('printer')
                    ->target('_blank')
                    ->type(Color::INFO()),

                    Link::make('Print Report (Scale 5)')
                    ->href(route('summary_5'))
                    ->style("width:35%")
                    ->icon('printer')
                    ->target('_blank')
                    ->type(Color::PRIMARY())

                    
                ]),
                
        
            ]),



            Layout::rows([
                Label::make('High Level Recommendation Summary Report')
                ->title('High Level Recommendation Summary Report')
                ->help("The High-Level Recommendation Summary Report provides an overview of risk assessments and corresponding recommendations for various asset types within the organization. The report categorizes assets into groups such as Hardware, Software, Data and Information, and others, and evaluates them based on their associated risk levels—Low, Medium, and High. It also outlines high-level decisions and recommendations for risk treatment, including whether assets should be Accepted, Reduced, Transferred, or Avoided. The report includes detailed counts of assets per risk level and decision, as well as a summary of the total number of assets assessed, helping decision-makers understand the overall security posture and prioritize risk mitigation actions effectively."),

                Group::make([
                    

                    Link::make('Print Report (Scale 3)')
                    ->href(route('highRecommend'))
                    ->icon('printer')
                    ->style("width:35%")
                    ->target('_blank')
                    ->type(Color::INFO()),

                    Link::make('Print Report (Scale 5)')
                    ->href(route('highRecommend_5'))
                    ->style("width:35%")
                    ->icon('printer')
                    ->target('_blank')
                    ->type(Color::PRIMARY()),
                ]),
                
        
            ]),


            Layout::rows([
                Label::make('Risk Treatment Plan Appendix')
                ->title('Risk Treatment Plan Appendix')
                ->help("The Risk Treatment Plan Appendix report provides a detailed breakdown of the risk treatment plans for various asset types within an organization. This appendix includes comprehensive tables that list each asset, its description, quantity, associated threats, existing safeguards, risk levels, planned actions, protection measures, responsible personnel, timelines, and residual risks. By organizing this information by asset type, the report helps stakeholders understand the specific risk treatments applied to each asset category, track the progress of risk mitigation efforts, and ensure that all necessary actions are being taken to manage and reduce risks effectively. This detailed appendix serves as a valuable resource for reviewing and auditing the organization's risk management strategies."),
                
                

                Group::make([
                    

                    Link::make('Print Report (Scale 3)')
                    ->href(route('treatmentAppendix'))
                    ->icon('printer')
                    ->style("width:35%")
                    ->target('_blank')
                    ->type(Color::INFO()),

                    Link::make('Print Report (Scale 5)')
                    ->href(route('treatmentAppendix_5'))
                    ->style("width:35%")
                    ->icon('printer')
                    ->target('_blank')
                    ->type(Color::PRIMARY()),
                ]),
                
        
            ]),

            Layout::rows([
                Label::make('Risk Treatment Plan Summary Report')
                ->title('Risk Treatment Plan Summary Report')
                ->help("The Risk Treatment Plan Summary Report provides a comprehensive overview of the risk treatment strategies implemented within an organization. This report is designed to help stakeholders understand the current status of risk treatments, including the specific actions taken, the responsible parties, and the timelines for each treatment. The report is structured to include detailed tables that summarize the protection measures for various asset types, the number of assets affected, the risk levels, and the high-level recommendations for each asset group. By organizing this information, the report aids in tracking progress, ensuring accountability, and facilitating informed decision-making regarding risk management efforts. This summary serves as a valuable resource for reviewing and auditing the organization's risk treatment strategies and their effectiveness."),

                Group::make([
                    

                    Link::make('Print Report (Scale 3)')
                    ->href(route('treatmentSummary'))
                    ->icon('printer')
                    ->style("width:35%")
                    ->target('_blank')
                    ->type(Color::INFO()),

                    Link::make('Print Report (Scale 5)')
                    ->href(route('treatmentsummary_5'))
                    ->style("width:35%")
                    ->icon('printer')
                    ->target('_blank')
                    ->type(Color::PRIMARY()),
                ]),
                
        
            ]),

        ];
    }


   
}