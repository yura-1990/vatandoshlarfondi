/*import Swagger from 'swagger-ui'
import 'swagger-ui/dist/swagger-ui.css';*/

import {SwaggerUIBundle} from 'swagger-ui-dist';
import 'swagger-ui/dist/swagger-ui.css';

SwaggerUIBundle({
    url: '/openapi',
    dom_id: '#swagger-api',
    presets: [
        SwaggerUIBundle.presets.apis,
        SwaggerUIBundle.SwaggerUIStandalonePreset,
    ],
});

/*SwaggerUI({
    dom_id: '#swagger-api',
    url: '/documentation',
});*/
