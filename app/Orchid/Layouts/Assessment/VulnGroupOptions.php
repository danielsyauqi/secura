<?php

namespace App\Orchid\Layouts\Assessment;

class VulnGroupOptions
{
    /**
     * Get vulnerability group options.
     *
     * @return array
     */
    public static function getVulnerabilityGroupOptions(?string $vulnerabilityType): array
    {
        switch ($vulnerabilityType) {
            case 'V1 Organizational Vulnerability':
                return [
                    'V1.1 Inadequate management of IT security' => 'V1.1 Inadequate management of IT security',
                    'V1.2 Inventory of assets is not maintained and classified' => 'V1.2 Inventory of assets is not maintained and classified',
                    'V1.3 No security in job definition and resourcing' => 'V1.3 No security in job definition and resourcing',
                    'V1.4 Inadequate mechanism to quantify/monitor incidents/malfunctions' => 'V1.4 Inadequate mechanism to quantify/monitor incidents/malfunctions',
                    'V1.5 Unprotected secure areas' => 'V1.5 Unprotected secure areas',
                    'V1.6 Inadequate equipment security' => 'V1.6 Inadequate equipment security',
                    'V1.7 No authorization for removal of property' => 'V1.7 No authorization for removal of property',
                    'V1.8 Undefined operational procedures and responsibilities' => 'V1.8 Undefined operational procedures and responsibilities',
                    'V1.9 Lack of housekeeping' => 'V1.9 Lack of housekeeping',
                    'V1.10 Insecure handling of media' => 'V1.10 Insecure handling of media',
                    'V1.11 Lack of security in exchanges of information and software' => 'V1.11 Lack of security in exchanges of information and software',
                    'V1.12 Inadequate business continuity management' => 'V1.12 Inadequate business continuity management',
                    'V1.13 Inadequate documentation' => 'V1.13 Inadequate documentation',
                    'V1.14 Lack of user training' => 'V1.14 Lack of user training',
                    'V1.15 A lack of compatible, or unsuitable, resources' => 'V1.15 A lack of compatible, or unsuitable, resources',
                    'V1.16 Lack of, or inadequate, maintenance' => 'V1.16 Lack of, or inadequate, maintenance',
                    'V1.17 Poor adjustment to change in the use of IT' => 'V1.17 Poor adjustment to change in the use of IT',
                    'V1.18 Data media are not available when required' => 'V1.18 Data media are not available when required',
                    'V1.19 Inadequately protected distributors' => 'V1.19 Inadequately protected distributors',
                    'V1.20 Impairment of IT usage on account of adverse working conditions' => 'V1.20 Impairment of IT usage on account of adverse working conditions',
                    'V1.21 Inadequate organization of the exchange of users' => 'V1.21 Inadequate organization of the exchange of users',
                    'V1.22 Lack of evaluation of auditing data' => 'V1.22 Lack of evaluation of auditing data',
                    'V1.23 Loss of confidentiality of sensitive data of the network to be protected' => 'V1.23 Loss of confidentiality of sensitive data of the network to be protected',
                    'V1.24 Reduction of transmission or execution speed caused by peer-to-peer functions' => 'V1.24 Reduction of transmission or execution speed caused by peer-to-peer functions',
                    'V1.25 Violation of copyright' => 'V1.25 Violation of copyright',
                    'V1.26 Inadequate domain planning' => 'V1.26 Inadequate domain planning',
                    'V1.27 Inappropriate restriction of user environment' => 'V1.27 Inappropriate restriction of user environment',
                    'V1.28 Uncontrolled usage of communication lines' => 'V1.28 Uncontrolled usage of communication lines',
                    'V1.29 Complexity of database access' => 'V1.29 Complexity of database access',
                    'V1.30 Poor organization of the exchange of database users' => 'V1.30 Poor organization of the exchange of database users',
                    'V1.31 Conceptual deficiencies of a network' => 'V1.31 Conceptual deficiencies of a network',
                    'V1.32 Insecure transport of files and data media' => 'V1.32 Insecure transport of files and data media',
                    'V1.33 Lack of, or inadequate, training of teleworkers' => 'V1.33 Lack of, or inadequate, training of teleworkers',
                    'V1.34 Delays caused by a temporarily restricted availability of teleworkers' => 'V1.34 Delays caused by a temporarily restricted availability of teleworkers',
                    'V1.35 Inadequate storage of media in the event of an emergency' => 'V1.35 Inadequate storage of media in the event of an emergency',
                    'V1.36 Strategy for the network system and management system is not laid down or insufficient' => 'V1.36 Strategy for the network system and management system is not laid down or insufficient',
                    'V1.37 Inappropriate handling of security incidents' => 'V1.37 Inappropriate handling of security incidents',
                    'V1.38 Uncontrolled use of faxes' => 'V1.38 Uncontrolled use of faxes',
                    'V1.39 Lack of or inadequate IT security management' => 'V1.39 Lack of or inadequate IT security management',
                ];
                
            case 'V2 Technical Vulnerability':
                return [
                    'V2.1 Lack of system planning and acceptance' => 'V2.1 Lack of system planning and acceptance',
                    'V2.2 Lack of controls against malicious software' => 'V2.2 Lack of controls against malicious software',
                    'V2.3 Inadequate network access control' => 'V2.3 Inadequate network access control',
                    'V2.4 Inadequate operating system access control' => 'V2.4 Inadequate operating system access control',
                    'V2.5 Inadequate application access control' => 'V2.5 Inadequate application access control',
                    'V2.6 Undefined security requirements for new systems' => 'V2.6 Undefined security requirements for new systems',
                    'V2.7 Inadequate security in application systems' => 'V2.7 Inadequate security in application systems',
                    'V2.8 Lack of cryptographic controls for information that has confidentiality, authenticity and integrity requirement' => 'V2.8 Lack of cryptographic controls for information that has confidentiality, authenticity and integrity requirement',
                    'V2.9 Inadequate security for system files' => 'V2.9 Inadequate security for system files',
                    'V2.10 Inadequate security in development and support processes' => 'V2.10 Inadequate security in development and support processes',
                    'V2.11 Defective network component/failure of network management system' => 'V2.11 Defective network component/failure of network management system',
                    'V2.12 Failure of a cryptomodule/key management' => 'V2.12 Failure of a cryptomodule/key management',

                ];
            case 'V3 Policy and Compliance Vulnerability':
                return [
                    'V3.1 Lack of, or insufficient policies and policies review' => 'V3.1 Lack of, or insufficient policies and policies review',
                    'V3.2 Undefined management authorization process for new information processing facilities' => 'V3.2 Undefined management authorization process for new information processing facilities',
                    'V3.3 Inadequate security controls for third party access' => 'V3.3 Inadequate security controls for third party access',
                    'V3.4 Inadequate security controls for outsourcing' => 'V3.4 Inadequate security controls for outsourcing',
                    'V3.5 Unclear disciplinary process on violation of organisation security policies/procedures' => 'V3.5 Unclear disciplinary process on violation of organisation security policies/procedures',
                    'V3.6 Unclear desk and clear screen policy' => 'V3.6 Unclear desk and clear screen policy',
                    'V3.7 Lack of user access management' => 'V3.7 Lack of user access management',
                    'V3.8 Lack of monitoring on system access and use' => 'V3.8 Lack of monitoring on system access and use',
                    'V3.9 Undefined policies and inadequate controls on mobile computing' => 'V3.9 Undefined policies and inadequate controls on mobile computing',
                    'V3.10 Undefined policies and inadequate controls on teleworking' => 'V3.10 Undefined policies and inadequate controls on teleworking',
                    'V3.11 Inadequate software test and release procedures' => 'V3.11 Inadequate software test and release procedures',
                    'V3.12 Not compliant with legal requirements' => 'V3.12 Not compliant with legal requirements',
                    'V3.13 Unplanned system audits' => 'V3.13 Unplanned system audits',
                    'V3.14 Lack of, or insufficient, rules' => 'V3.14 Lack of, or insufficient, rules',
                    'V3.15 Insufficient knowledge of rules and procedures' => 'V3.15 Insufficient knowledge of rules and procedures',
                    'V3.16 Insufficient monitoring of IT security measures' => 'V3.16 Insufficient monitoring of IT security measures',
                    'V3.17 Unauthorized admission to rooms requiring protection' => 'V3.17 Unauthorized admission to rooms requiring protection',
                    'V3.18 Unauthorized use of rights' => 'V3.18 Unauthorized use of rights',
                    'V3.19 Uncontrolled use of resources' => 'V3.19 Uncontrolled use of resources',
                    'V3.20 Insufficient documentation on cabling' => 'V3.20 Insufficient documentation on cabling',
                    'V3.21 Non-regulated change of users in the case of laptop PCs' => 'V3.21 Non-regulated change of users in the case of laptop PCs',
                    'V3.22 Inadequate labeling of data media' => 'V3.22 Inadequate labeling of data media',
                    'V3.23 Improper delivery of data media' => 'V3.23 Improper delivery of data media',
                    'V3.24 Inadequate key management for encryption' => 'V3.24 Inadequate key management for encryption',
                    'V3.25 Inadequate supply of printing consumables for fax machines' => 'V3.25 Inadequate supply of printing consumables for fax machines',
                    'V3.26 Software testing with production data' => 'V3.26 Software testing with production data',
                    'V3.27 Inadequate line bandwidth' => 'V3.27 Inadequate line bandwidth',
                    'V3.28 Lack of, or inadequate implementation of database security mechanisms' => 'V3.28 Lack of, or inadequate implementation of database security mechanisms',
                    'V3.29 Incompatible active and passive network components' => 'V3.29 Incompatible active and passive network components',
                    'V3.30 Inadequate disposal of data media and documents at the home workplace' => 'V3.30 Inadequate disposal of data media and documents at the home workplace',
                    'V3.31 Longer response times in the event of an IT system breakdown' => 'V3.31 Longer response times in the event of an IT system breakdown',
                    'V3.32 Inadequate regulations concerning substitution of teleworkers' => 'V3.32 Inadequate regulations concerning substitution of teleworkers',
                    'V3.33 Loss of confidentiality through hidden pieces of data' => 'V3.33 Loss of confidentiality through hidden pieces of data',
                    'V3.34 Uncontrolled use of electronic email' => 'V3.34 Uncontrolled use of electronic email',
                    'V3.35 Inadequate description of files' => 'V3.35 Inadequate description of files',
                    'V3.36 Unauthorized collection of personal data' => 'V3.36 Unauthorized collection of personal data',
                    'V3.37 Inappropriate administration of access rights' => 'V3.37 Inappropriate administration of access rights',
                ];
            default:
                return ['' => 'Choose vulnerability type'];
        }
    }

    /**
     * Get vulnerability name options.
     *
     * @return array
     */
}
