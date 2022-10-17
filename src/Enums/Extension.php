<?php

namespace Msaaq\Nelc\Enums;

enum Extension: string
{
    /**
     * Used to differentiate between attempts within a given registration. This extension is especially useful for games,
     * for example in the Tetris prototype at http://tincanapi.com/prototypes this extension is used as an identifier for each new game of Tetris.
     */
    case ATTEMPT_ID = 'http://id.tincanapi.com/extension/attempt-id';

    /**
     * Value is an object containing key/value pairs describing various elements of a web browser. Same as user-agent.
     */
    case BROWSER_INFORMATION = 'http://id.tincanapi.com/extension/browser-info';

    /**
     * Context extension containing the URL of a public certificate that can be used to verify the signature of the statement.
     */
    case JWS_CERTIFICATE_LOCATION = 'http://id.tincanapi.com/extension/jws-certificate-location';

    case PLATFORM = 'https://nelc.gov.sa/extensions/platform';
}
