<?php
return [
    /**
     * Certificate info that is used in testing.
     *
     * If left blank, tests which need this info will not be carried out.
     */
    'certificate' => [
        'hex' => null,
        'id' => null
    ],

    /**
     * Signature for testing.
     *
     * If left blank, tests which need this info will not be carried out.
     */
    'signature' => [
        'hex' => null
    ],

    /**
     * Authentication info.
     *
     * If left blank, tests which need this info will not be carried out.
     */
    'authenticate' => [
        // Sample: GN=Mari-Liis/SN=Männik/serialNumber=47101010033/C=EST
        'info' => null
    ]
];