<?php

namespace App\Orchid\Layouts\Assessment;

class SafeguardOptions
{
    /**
     * Get safeguard group options based on safeguard type.
     *
     * @param string|null $safeguardType
     * @return array
     */
    public static function getSafeguardGroupOptions(?string $safeguardType): array
    {
        return match ($safeguardType) {
            'ISMS Clause' => [
                '' => 'Select ISMS Clause',
                'Clause 4: Context of the Organization' => 'Clause 4: Context of the Organization',
                'Clause 5: Leadership' => 'Clause 5: Leadership',
                'Clause 6: Planning' => 'Clause 6: Planning',
                'Clause 7: Support' => 'Clause 7: Support',
                'Clause 8: Operation' => 'Clause 8: Operation',
                'Clause 9: Performance Evaluation' => 'Clause 9: Performance Evaluation',
                'Clause 10: Improvement' => 'Clause 10: Improvement',
            ],
            'Annex A' => [
                '' => 'Select Annex A Control',
                'A.5 Organizational Controls' => 'A.5 Organizational Controls',
                'A.6 People Controls' => 'A.6 People Controls',
                'A.7 Physical Controls' => 'A.7 Physical Controls',
                'A.8 Technological Controls' => 'A.8 Technological Controls',
                'A.9 Access Control' => 'A.9 Access Control',
                'A.10 Cryptography' => 'A.10 Cryptography',
                'A.11 Physical and Environmental Security' => 'A.11 Physical and Environmental Security',
                'A.12 Operations Security' => 'A.12 Operations Security',
                'A.13 Communications Security' => 'A.13 Communications Security',
                'A.14 System Acquisition, Development, and Maintenance' => 'A.14 System Acquisition, Development, and Maintenance',
                'A.15 Supplier Relationships' => 'A.15 Supplier Relationships',
                'A.16 Information Security Incident Management' => 'A.16 Information Security Incident Management',
                'A.17 Information Security Aspects of Business Continuity Management' => 'A.17 Information Security Aspects of Business Continuity Management',
                'A.18 Compliance' => 'A.18 Compliance',
            ],
            default => ['' => 'Choose safeguard type'],
        };
    }

    /**
     * Get safeguard ID options based on safeguard group.
     *
     * @param string|null $safeguardGroup
     * @return array
     */
    public static function getSafeguardIdOptions(?string $safeguardGroup): array
    {
        if (!$safeguardGroup) {
            return ['' => 'Choose safeguard ID']; // Return empty if no safeguard group selected
        }

        switch ($safeguardGroup) {
            case "Clause 4: Context of the Organization":
                return [
                    '' => 'Select ISMS Clause',
                    '4.1 Understanding the organization and its context' => '4.1 Understanding the organization and its context',
                    '4.2 Understanding the needs and expectations of interested parties' => '4.2 Understanding the needs and expectations of interested parties',
                    '4.3 Determining the scope of the information security management system' => '4.3 Determining the scope of the information security management system',
                    '4.4 Information security management system' => '4.4 Information security management system',
                    '4.5 Leadership and commitment' => '4.5 Leadership and commitment',
                ];
            
            case "Clause 5: Leadership":
                return [
                    '' => 'Select ISMS Clause',
                    '5.1 Leadership and commitment' => '5.1 Leadership and commitment',
                    '5.2 Policy' => '5.2 Policy',
                    '5.3 Organizational roles, responsibilities and authorities' => '5.3 Organizational roles, responsibilities and authorities',
                ];
            case "Clause 6: Planning":
                return [
                    '' => 'Select ISMS Clause',
                    '6.1 Actions to address risks and opportunities' => '6.1 Actions to address risks and opportunities',
                    '6.1.1 General' => '6.1.1 General',
                    '6.1.2 Information security risk assessment' => '6.1.2 Information security risk assessment',
                    '6.1.3 Information security risk treatment' => '6.1.3 Information security risk treatment',
                    '6.2 Information security objectives and planning to achieve them' => '6.2 Information security objectives and planning to achieve them',
                ];
            case "Clause 7: Support":
                return [
                    '' => 'Select ISMS Clause',
                    '7.1 Resources' => '7.1 Resources',
                    '7.2 Competence' => '7.2 Competence',
                    '7.3 Awareness' => '7.3 Awareness',
                    '7.4 Communication' => '7.4 Communication',
                    '7.5 Documented information' => '7.5 Documented information',
                    '7.5.1 General' => '7.5.1 General',
                    '7.5.2 Creating and updating' => '7.5.2 Creating and updating',
                    '7.5.3 Control of documented information' => '7.5.3 Control of documented information',
                ];
            case "Clause 8: Operation":
                return [
                    '' => 'Select ISMS Clause',
                    '8.1 Operational planning and control' => '8.1 Operational planning and control',
                    '8.2 Information security risk assessment' => '8.2 Information security risk assessment',
                    '8.3 Information security risk treatment' => '8.3 Information security risk treatment',
                ];
            case "Clause 9: Performance Evaluation":
                return [
                    '' => 'Select ISMS Clause',
                    '9.1 Monitoring, measurement, analysis, and evaluation' => '9.1 Monitoring, measurement, analysis, and evaluation',
                    '9.2 Internal audit' => '9.2 Internal audit',
                    '9.2.1 General' => '9.2.1 General',
                    '9.2.2 Internal audit programme' => '9.2.2 Internal audit programme',
                    '9.3 Management review' => '9.3 Management review',
                    '9.3.1 General' => '9.3.1 General',
                    '9.3.2 Management review inputs' => '9.3.2 Management review inputs',
                    '9.3.3 Management review results' => '9.3.3 Management review results',
                ];
            case "Clause 10: Improvement":
                return [
                    '' => 'Select ISMS Clause',
                    '10.1 Continual improvement' => '10.1 Continual improvement',
                    '10.2 Nonconformity and corrective action' => '10.2 Nonconformity and corrective action',
                ];
            case "A.5 Organizational Controls":
                return [
                    '' => 'Select Annex A Control',
                    'A.5.1 Information security policy' => 'A.5.1 Information security policy',
                    'A.5.2 Information security roles and responsibilities' => 'A.5.2 Information security roles and responsibilities',
                    'A.5.3 Segregation of duties' => 'A.5.3 Segregation of duties',
                    'A.5.4 Management responsibilities' => 'A.5.4 Management responsibilities',
                    'A.5.5 Contact with authorities' => 'A.5.5 Contact with authorities',
                    'A.5.6 Contact with special interest groups' => 'A.5.6 Contact with special interest groups',
                    'A.5.7 Threat intelligence' => 'A.5.7 Threat intelligence',
                    'A.5.8 Information security in project management' => 'A.5.8 Information security in project management',
                ];
            case "A.6 People Controls":
                return [
                    '' => 'Select Annex A Control',
                    'A.6.1 Screening' => 'A.6.1 Screening',
                    'A.6.2 Terms and conditions of employment' => 'A.6.2 Terms and conditions of employment',
                    'A.6.3 Information security awareness, education and training' => 'A.6.3 Information security awareness, education and training',
                    'A.6.4 Disciplinary process' => 'A.6.4 Disciplinary process',
                    'A.6.5 Responsibilities after termination or change of employment' => 'A.6.5 Responsibilities after termination or change of employment',
                    'A.6.6 Confidentiality or non-disclosure agreements' => 'A.6.6 Confidentiality or non-disclosure agreements',
                    'A.6.7 Remote working' => 'A.6.7 Remote working',
                    'A.6.8 Information security event reporting' => 'A.6.8 Information security event reporting',
                ];
            case "A.7 Physical Controls":
                return [
                    '' => 'Select Annex A Control',
                    'A.7.1 Physical security perimeters' => 'A.7.1 Physical security perimeters',
                    'A.7.2 Physical entry' => 'A.7.2 Physical entry',
                    'A.7.3 Securing offices, rooms and facilities' => 'A.7.3 Securing offices, rooms and facilities',
                    'A.7.4 Physical security monitoring' => 'A.7.4 Physical security monitoring',
                    'A.7.5 Protecting against physical and environmental threats' => 'A.7.5 Protecting against physical and environmental threats',
                    'A.7.6 Working in secure areas' => 'A.7.6 Working in secure areas',
                    'A.7.7 Clear desk and clear screen' => 'A.7.7 Clear desk and clear screen',
                    'A.7.8 Equipment siting and protection' => 'A.7.8 Equipment siting and protection',
                    'A.7.9 Security of assets off-premises' => 'A.7.9 Security of assets off-premises',
                    'A.7.10 Storage media' => 'A.7.10 Storage media',
                ];
            case "A.8 Technological Controls":
                return [
                    '' => 'Select Annex A Control',
                    'A.8.30 Separation of development, test and production environments' => 'A.8.30 Separation of development, test and production environments',
                    'A.8.31 Configuration management' => 'A.8.31 Configuration management',
                    'A.8.32 Application software security' => 'A.8.32 Application software security',
                ];
            default:
            return ['' => 'Choose safeguard ID'];
        }
       
    }
}
