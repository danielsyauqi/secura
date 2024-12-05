<?php

namespace App\Orchid\Layouts\Assessment;

class ThreatGroupOptions
{
    /**
     * Get threat group options.
     *
     * @return array
     */
    public static function getThreatGroupOptions(?string $threatType): array
    {
        switch ($threatType) {
            case "T1 Physical Threats":
                return [
                    '' => 'Select Threat',
                    'T1.1 Fire' => 'T1.1 Fire',
                    'T1.2 Water' => 'T1.2 Water',
                    'T1.3 Pollution, harmful radiation' => 'T1.3 Pollution, harmful radiation',
                    'T1.4 Major accident' => 'T1.4 Major accident',
                    'T1.5 Explosion' => 'T1.5 Explosion',
                    'T1.6 Dust, corrosion, freezing' => 'T1.6 Dust, corrosion, freezing',
                ];
            
            case "T2 Natural Threats":
                return [
                    '' => 'Select Threat',
                    'T2.1 Climatic phenomenon' => 'T2.1 Climatic phenomenon',
                    'T2.2 Seismic phenomenon' => 'T2.2 Seismic phenomenon',
                    'T2.3 Volcanic phenomenon' => 'T2.3 Volcanic phenomenon',
                    'T2.4 Meteorological phenomenon' => 'T2.4 Meteorological phenomenon',
                    'T2.5 Pandemic/epidemic phenomenon' => 'T2.5 Pandemic/epidemic phenomenon',
                ];
            
            case "T3 Infrastructure Failures":
                return [
                    '' => 'Select Threat',
                    'T3.1 Failure of a supply system' => 'T3.1 Failure of a supply system',
                    'T3.2 Failure of cooling or ventilation system' => 'T3.2 Failure of cooling or ventilation system',
                    'T3.3 Loss of power supply' => 'T3.3 Loss of power supply',
                    'T3.4 Failure of a telecommunications network' => 'T3.4 Failure of a telecommunications network',
                    'T3.5 Failure of telecommunication equipment' => 'T3.5 Failure of telecommunication equipment',
                ];
            
            case "T4 Technical Failures":
                return [
                    '' => 'Select Threat',
                    'T4.1 Saturation of the information system' => 'T4.1 Saturation of the information system',
                    'T4.2 Violation of information system maintainability' => 'T4.2 Violation of information system maintainability',
                    'T4.3 Electromagnetic radiation' => 'T4.3 Electromagnetic radiation',
                    'T4.4 Electromagnetic pulses' => 'T4.4 Electromagnetic pulses',
                ];
            
            case "T5 Human Actions":
                return [
                    '' => 'Select Threat',
                    'T5.1 Terror attack, sabotage' => 'T5.1 Terror attack, sabotage',
                    'T5.2 Social Engineering' => 'T5.2 Social Engineering',
                    'T5.3 Interception of radiation of a device' => 'T5.3 Interception of radiation of a device',
                    'T5.4 Remote spying' => 'T5.4 Remote spying',
                    'T5.5 Eavesdropping' => 'T5.5 Eavesdropping',
                    'T5.6 Theft of media or documents' => 'T5.6 Theft of media or documents',
                    'T5.7 Theft of equipment' => 'T5.7 Theft of equipment',
                    'T5.8 Theft of digital identity or credentials' => 'T5.8 Theft of digital identity or credentials',
                    'T5.9 Retrieval of recycled or discarded media' => 'T5.9 Retrieval of recycled or discarded media',
                    'T5.10 Disclosure of information' => 'T5.10 Disclosure of information',
                    'T5.11 Data input from untrustworthy sources' => 'T5.11 Data input from untrustworthy sources',
                    'T5.12 Tampering with hardware' => 'T5.12 Tampering with hardware',
                    'T5.13 Tampering with software' => 'T5.13 Tampering with software',
                    'T5.14 Drive-by-exploits using web-based communication' => 'T5.14 Drive-by-exploits using web-based communication',
                    'T5.15 Replay attack, man-in-the-middle attack' => 'T5.15 Replay attack, man-in-the-middle attack',
                    'T5.16 Unauthorized processing of personal data' => 'T5.16 Unauthorized processing of personal data',
                    'T5.17 Unauthorized entry to facilities' => 'T5.17 Unauthorized entry to facilities',
                    'T5.18 Unauthorized use of devices' => 'T5.18 Unauthorized use of devices',
                    'T5.19 Incorrect use of devices' => 'T5.19 Incorrect use of devices',
                    'T5.20 Damaging devices or media' => 'T5.20 Damaging devices or media',
                    'T5.21 Fraudulent copying of software' => 'T5.21 Fraudulent copying of software',
                    'T5.22 Use of counterfeit or copied software' => 'T5.22 Use of counterfeit or copied software',
                    'T5.23 Corruption of data' => 'T5.23 Corruption of data',
                    'T5.24 Illegal processing of data' => 'T5.24 Illegal processing of data',
                    'T5.25 Sending or distributing of malware' => 'T5.25 Sending or distributing of malware',
                    'T5.26 Position detection' => 'T5.26 Position detection',
                ];
            
            case "T6 Organizational Threats":
                return [
                    '' => 'Select Threat',
                    'T6.1 Lack of staff' => 'T6.1 Lack of staff',
                    'T6.2 Lack of resources' => 'T6.2 Lack of resources',
                    'T6.3 Failure of service providers' => 'T6.3 Failure of service providers',
                    'T6.4 Violation of laws or regulations' => 'T6.4 Violation of laws or regulations',
                ];
            
                

        default:
            return ['' => 'Choose threat selection'];
        }

    }
}
