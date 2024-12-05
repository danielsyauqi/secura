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

    /**
     * Get safeguard ID options based on safeguard group.
     *
     * @param string|null $safeguardGroup
     * @return array
     */
    public static function getSafeguardIdOptions(?string $safeguardGroup, ?string $type): array
    {
        if (!$safeguardGroup && $type === 'Safeguard') {
            return ['' => 'Choose safeguard ID']; // Return empty if no safeguard group selected
        }else if (!$safeguardGroup && $type === 'Protection') {
            return ['' => 'Choose protection ID']; // Return empty if no safeguard group selected

        }

        switch ($safeguardGroup) {
            case "S1 Organizational Controls":
                return [
                    '' => 'Select Safeguard',
                    'S1.1 Policies for information security' => 'S1.1 Policies for information security',
                    'S1.2 Information security roles and responsibilities' => 'S1.2 Information security roles and responsibilities',
                    'S1.3 Segregation of duties' => 'S1.3 Segregation of duties',
                    'S1.4 Management responsibilities' => 'S1.4 Management responsibilities',
                    'S1.5 Contact with authorities' => 'S1.5 Contact with authorities',
                    'S1.6 Contact with special interest groups' => 'S1.6 Contact with special interest groups',
                    'S1.7 Threat intelligence' => 'S1.7 Threat intelligence',
                    'S1.8 Information security in project management' => 'S1.8 Information security in project management',
                    'S1.9 Inventory of Information and other associated assets' => 'S1.9 Inventory of Information and other associated assets',
                    'S1.10 Acceptable use of information and other associated assets' => 'S1.10 Acceptable use of information and other associated assets',
                    'S1.11 Return of assets' => 'S1.11 Return of assets',
                    'S1.12 Classification of information' => 'S1.12 Classification of information',
                    'S1.13 Labelling of Information' => 'S1.13 Labelling of Information',
                    'S1.14 Information Transfer' => 'S1.14 Information Transfer',
                    'S1.15 Information Security in supplier relationships' => 'S1.15 Information Security in supplier relationships',
                    'S1.16 Addressing information security within supplier agreements' => 'S1.16 Addressing information security within supplier agreements',
                    'S1.17 Managing information security in the ICT supply chain' => 'S1.17 Managing information security in the ICT supply chain',
                    'S1.18 Legal, statutory, regulatory and contractual requirements' => 'S1.18 Legal, statutory, regulatory and contractual requirements',
                    'S1.19 Intellectual Property Rights (IPR)' => 'S1.19 Intellectual Property Rights (IPR)',
                    'S1.20 Protection of Records' => 'S1.20 Protection of Records',
                    'S1.21 Privacy and protection of personally identifiable information (PII)' => 'S1.21 Privacy and protection of personally identifiable information (PII)',
                    'S1.22 Independent Review of Information Security' => 'S1.22 Independent Review of Information Security',
                    'S1.23 Compliance with security policy and standards for information security' => 'S1.23 Compliance with security policy and standards for information security',
                    'S1.24 Documented Operating Procedures' => 'S1.24 Documented Operating Procedures',
                ];
            
            case "S2 People Controls":
                return [
                    '' => 'Select Safeguard',
                    'S2.1 Screening' => 'S2.1 Screening',
                    'S2.2 Terms and conditions of employment' => 'S2.2 Terms and conditions of employment',
                    'S2.3 Information security awareness, education and training' => 'S2.3 Information security awareness, education and training',
                    'S2.4 Disciplinary process' => 'S2.4 Disciplinary process',
                    'S2.5 Responsibilities after termination or change of employment' => 'S2.5 Responsibilities after termination or change of employment',
                    'S2.6 Confidentiality or non-disclosure agreements' => 'S2.6 Confidentiality or non-disclosure agreements',
                    'S2.7 Working in secure areas' => 'S2.7 Working in secure areas',
                    'S2.8 Remote working' => 'S2.8 Remote working',
                    'S2.9 Clear desk and clear screen' => 'S2.9 Clear desk and clear screen',
                    'S2.10 Information security event reporting' => 'S2.10 Information security event reporting',
                ];
            
            case "S3 Physical Controls":
                return [
                    '' => 'Select Safeguard',
                    'S3.1 Physical security perimeters' => 'S3.1 Physical security perimeters',
                    'S3.2 Physical entry' => 'S3.2 Physical entry',
                    'S3.3 Securing offices, rooms and facilities' => 'S3.3 Securing offices, rooms and facilities',
                    'S3.4 Physical security monitoring' => 'S3.4 Physical security monitoring',
                    'S3.5 Protecting against physical and environmental threats' => 'S3.5 Protecting against physical and environmental threats',
                    'S3.6 Equipment siting and protection' => 'S3.6 Equipment siting and protection',
                    'S3.7 Security of assets off-premises' => 'S3.7 Security of assets off-premises',
                    'S3.8 Storage media' => 'S3.8 Storage media',
                    'S3.9 Cabling security' => 'S3.9 Cabling security',
                    'S3.10 Equipment maintenance' => 'S3.10 Equipment maintenance',
                    'S3.11 Secure disposal or re-use of equipment' => 'S3.11 Secure disposal or re-use of equipment',
                    'S3.12 Redundancy of information processing facilities' => 'S3.12 Redundancy of information processing facilities',
                ];
            
            case "S4 Technological Controls":
                return [
                    '' => 'Select Safeguard',
                    'S4.1 User end point devices' => 'S4.1 User end point devices',
                    'S4.2 Privileged access rights' => 'S4.2 Privileged access rights',
                    'S4.3 Information access restriction' => 'S4.3 Information access restriction',
                    'S4.4 Access to source code' => 'S4.4 Access to source code',
                    'S4.5 Secure authentication' => 'S4.5 Secure authentication',
                    'S4.6 Capacity management' => 'S4.6 Capacity management',
                    'S4.7 Protection against malware' => 'S4.7 Protection against malware',
                    'S4.8 Configuration management' => 'S4.8 Configuration management',
                    'S4.9 Information deletion' => 'S4.9 Information deletion',
                    'S4.10 Data masking' => 'S4.10 Data masking',
                    'S4.11 Data leakage prevention' => 'S4.11 Data leakage prevention',
                    'S4.12 Information backup' => 'S4.12 Information backup',
                    'S4.13 Secure disposal or re-use of equipment' => 'S4.13 Secure disposal or re-use of equipment',
                    'S4.14 Logging' => 'S4.14 Logging',
                    'S4.15 Monitoring activities' => 'S4.15 Monitoring activities',
                    'S4.16 Clock synchronization' => 'S4.16 Clock synchronization',
                    'S4.17 Use of privileged utility programs' => 'S4.17 Use of privileged utility programs',
                    'S4.18 Installation of software on operational systems' => 'S4.18 Installation of software on operational systems',
                    'S4.19 Networks security' => 'S4.19 Networks security',
                    'S4.20 Security of network services' => 'S4.20 Security of network services',
                    'S4.21 Segregation of networks' => 'S4.21 Segregation of networks',
                    'S4.22 Web filtering' => 'S4.22 Web filtering',
                    'S4.23 Use of cryptography' => 'S4.23 Use of cryptography',
                    'S4.24 Secure development life cycle' => 'S4.24 Secure development life cycle',
                    'S4.25 Application security requirements' => 'S4.25 Application security requirements',
                    'S4.26 Secure system architecture and engineering principles' => 'S4.26 Secure system architecture and engineering principles',
                    'S4.27 Secure coding' => 'S4.27 Secure coding',
                    'S4.28 Security testing in development and acceptance' => 'S4.28 Security testing in development and acceptance',
                    'S4.29 Outsourced development' => 'S4.29 Outsourced development',
                    'S4.30 Separation of development, test and production environments' => 'S4.30 Separation of development, test and production environments',
                    'S4.31 Change management' => 'S4.31 Change management',
                    'S4.32 Test information' => 'S4.32 Test information',
                    'S4.33 Protection of information systems during audit testing' => 'S4.33 Protection of information systems during audit testing',
                ];            
                           
            default:
            return ['' => 'Choose safeguard ID'];
        }
       
    }
}
