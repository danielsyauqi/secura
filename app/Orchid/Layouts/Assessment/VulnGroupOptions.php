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
            case "V1 Hardware":
                return [
                    '' => 'Select Vulnerability',
                    'V1.1 Insufficient maintenance/faulty installation of storage media' => 'V1.1 Insufficient maintenance/faulty installation of storage media',
                    'V1.2 Insufficient periodic replacement schemes for equipment' => 'V1.2 Insufficient periodic replacement schemes for equipment',
                    'V1.3 Susceptibility to humidity, dust, soiling' => 'V1.3 Susceptibility to humidity, dust, soiling',
                    'V1.4 Sensitivity to electromagnetic radiation' => 'V1.4 Sensitivity to electromagnetic radiation',
                    'V1.5 Insufficient configuration change control' => 'V1.5 Insufficient configuration change control',
                    'V1.6 Susceptibility to voltage variations' => 'V1.6 Susceptibility to voltage variations',
                    'V1.7 Susceptibility to temperature variations' => 'V1.7 Susceptibility to temperature variations',
                    'V1.8 Unprotected storage' => 'V1.8 Unprotected storage',
                    'V1.9 Lack of care at disposal' => 'V1.9 Lack of care at disposal',
                    'V1.10 Uncontrolled copying' => 'V1.10 Uncontrolled copying',
                    'V1.11 Unnecessary services enabled' => 'V1.11 Unnecessary services enabled',
                ];
            
            case "V2 Software":
                return [
                    '' => 'Select Vulnerability',
                    'V2.1 No or insufficient software testing' => 'V2.1 No or insufficient software testing',
                    'V2.2 Well-known flaws in the software' => 'V2.2 Well-known flaws in the software',
                    'V2.3 No “logout” when leaving the workstation' => 'V2.3 No “logout” when leaving the workstation',
                    'V2.4 Disposal or reuse of storage media without proper erasure' => 'V2.4 Disposal or reuse of storage media without proper erasure',
                    'V2.5 Incorrect use of software and hardware' => 'V2.5 Incorrect use of software and hardware',
                    'V2.6 Incorrect allocation of access rights' => 'V2.6 Incorrect allocation of access rights',
                    'V2.7 Widely-distributed software' => 'V2.7 Widely-distributed software',
                    'V2.8 Applying application programs to the wrong data in terms of time' => 'V2.8 Applying application programs to the wrong data in terms of time',
                    'V2.9 Complicated user interface' => 'V2.9 Complicated user interface',
                    'V2.10 Incorrect parameter set up' => 'V2.10 Incorrect parameter set up',
                    'V2.11 Uncontrolled downloading and use of software' => 'V2.11 Uncontrolled downloading and use of software',
                    'V2.12 Immature or new software' => 'V2.12 Immature or new software',
                    'V2.13 Unclear or incomplete specifications for developers' => 'V2.13 Unclear or incomplete specifications for developers',
                    'V2.14 Ineffective change control' => 'V2.14 Ineffective change control',
                ];
            
            case "V3 Network":
                return [
                    '' => 'Select Vulnerability',
                    'V3.1 Unprotected communication lines' => 'V3.1 Unprotected communication lines',
                    'V3.2 Unprotected sensitive traffic' => 'V3.2 Unprotected sensitive traffic',
                    'V3.3 Single point of failure' => 'V3.3 Single point of failure',
                    'V3.4 Insecure network architecture' => 'V3.4 Insecure network architecture',
                    'V3.5 Poor joint cabling' => 'V3.5 Poor joint cabling',
                    'V3.6 Poor security awareness' => 'V3.6 Poor security awareness',
                    'V3.7 Unprotected public network connections' => 'V3.7 Unprotected public network connections',
                    'V3.8 Inadequate network management (resilience of routing)' => 'V3.8 Inadequate network management (resilience of routing)',
                    'V3.9 Unstable power grid' => 'V3.9 Unstable power grid',
                    'V3.10 Insufficient or lack of provisions (concerning security) in contracts with customers and/or third parties' => 'V3.10 Insufficient or lack of provisions (concerning security) in contracts with customers and/or third parties',
                    'V3.11 Unsupervised work by outside or cleaning staff' => 'V3.11 Unsupervised work by outside or cleaning staff',
                ];
            
            case "V4 Personnel":
                return [
                    '' => 'Select Vulnerability',
                    'V4.1 Absence of personnel' => 'V4.1 Absence of personnel',
                    'V4.2 Inadequate recruitment procedures' => 'V4.2 Inadequate recruitment procedures',
                    'V4.3 Insufficient security training' => 'V4.3 Insufficient security training',
                    'V4.4 Insufficient or lack of monitoring mechanisms' => 'V4.4 Insufficient or lack of monitoring mechanisms',
                    'V4.5 Insufficient or lack of policies for the correct use of telecommunications media and messaging' => 'V4.5 Insufficient or lack of policies for the correct use of telecommunications media and messaging',
                    'V4.6 Ineffective or lack of mechanisms for identification and authentication of sender and receiver' => 'V4.6 Ineffective or lack of mechanisms for identification and authentication of sender and receiver',
                    'V4.7 Insufficient or lack of fault reports recorded in administrator and operator logs' => 'V4.7 Insufficient or lack of fault reports recorded in administrator and operator logs',
                    'V4.8 Disciplinary process in case of information security incident not defined, or not functioning properly' => 'V4.8 Disciplinary process in case of information security incident not defined, or not functioning properly',
                ];
            
            case "V5 Site":
                return [
                    '' => 'Select Vulnerability',
                    'V5.1 Location in an area susceptible to flood' => 'V5.1 Location in an area susceptible to flood',
                    'V5.2 Inadequate or careless use of physical access control to buildings and rooms' => 'V5.2 Inadequate or careless use of physical access control to buildings and rooms',
                    'V5.3 Insufficient physical protection of the building, doors and windows' => 'V5.3 Insufficient physical protection of the building, doors and windows',
                    'V5.4 Procedure of monitoring of information processing facilities not developed, or its implementation is ineffective' => 'V5.4 Procedure of monitoring of information processing facilities not developed, or its implementation is ineffective',
                    'V5.5 Insufficient control of off-premise assets' => 'V5.5 Insufficient control of off-premise assets',
                ];
            
            case "V6 Organization":
                return [
                    '' => 'Select Vulnerability',
                    'V6.1 Formal procedure for user registration and de-registration not developed, or its implementation is ineffective' => 'V6.1 Formal procedure for user registration and de-registration not developed, or its implementation is ineffective',
                    'V6.2 Formal process for access right review (supervision) not developed, or its implementation is ineffective' => 'V6.2 Formal process for access right review (supervision) not developed, or its implementation is ineffective',
                    'V6.3 Insufficient provisions (concerning security) in contracts with customers and/or third parties' => 'V6.3 Insufficient provisions (concerning security) in contracts with customers and/or third parties',
                    'V6.4 Audits (supervision) not conducted on a regular basis' => 'V6.4 Audits (supervision) not conducted on a regular basis',
                    'V6.5 Procedures of risk identification and assessment not developed, or its implementation is ineffective' => 'V6.5 Procedures of risk identification and assessment not developed, or its implementation is ineffective',
                    'V6.6 Procedures for reporting security weaknesses not developed, or their implementation is ineffective' => 'V6.6 Procedures for reporting security weaknesses not developed, or their implementation is ineffective',
                    'V6.7 Formal procedure for ISMS documentation control not developed, or its implementation is ineffective' => 'V6.7 Formal procedure for ISMS documentation control not developed, or its implementation is ineffective',
                    'V6.8 Formal procedure for ISMS record supervision not developed, or its implementation is ineffective' => 'V6.8 Formal procedure for ISMS record supervision not developed, or its implementation is ineffective',
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
