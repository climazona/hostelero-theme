import './dist/cookieconsent.umd.js';

CookieConsent.run({
    disablePageInteraction: true,
    
    onFirstConsent: ({cookie}) => {
        window.dataLayer.push({ 'event': 'client-consent-update' });
        console.log('Trigger Primera Configuración');
    },
    
    onChange: ({cookie, changedCategories, changedServices}) => {
        window.dataLayer.push({ 'event': 'gtm-consent-updated' });
        console.log('Trigger Configuración Cambiada');
    },

    categories: {
        necessary: {
            enabled: true,
            readOnly: true,
        },
        functionality: {},
        analytics: {
            services: {
                ga4: {
                    label:
                        '<a href="https://support.google.com/analytics/answer/11397207?hl=es" rel="nofollow" target="_blank">Google Analytics 4</a>',
                    onAccept: () => {
                        console.log('ga4 accepted');
                    },
                    onReject: () => {
                        console.log('ga4 rejected');
                    },
                    cookies: [
                        {
                            name: /^_ga/,
                        },
                    ],
                },
                sl: {
                    label:
                        '<a href="https://help.smartlook.com/docs/cookies-smartlook" rel="nofollow" target="_blank">Smartlook</a>',
                    onAccept: () => {
                        console.log('sl accepted');
                    },
                    onReject: () => {
                        console.log('sl rejected');
                    },
                    cookies: [
                        {
                            name: /^SL_/,
                        },
                    ],
                },
            },
        },
    },
    
    guiOptions: {
        consentModal: {
            layout: 'cloud inline',
            position: 'middle center',
            flipButtons: false,
            equalWeightButtons: true
        },
        preferencesModal: {
            layout: 'box',
            flipButtons: false,
            equalWeightButtons: true
        }
    },

    language: {
        default: 'es',
        translations: {
            es: {
                consentModal: {
                    title: 'Nuestra tienda utiliza cookies 🍪',
                    description: 'Climazona y terceros seleccionados usan cookies para fines técnicos y, con su consentimiento, para análisis estadísticos. Consulta nuestra <a href="/politica-de-cookies/" rel="nofollow">política de cookies</a>. Puede otorgar o retirar su consentimiento en cualquier momento.',
                    acceptAllBtn: 'Aceptar todo',
                    acceptNecessaryBtn: 'Rechazar todo',
                    showPreferencesBtn: 'Personalizar configuración'
                },
                preferencesModal: {
                    title: 'Configurar sus preferencias de Privacidad',
                    acceptAllBtn: 'Aceptar todo',
                    acceptNecessaryBtn: 'Rechazar todo',
                    savePreferencesBtn: 'Aceptar la selección actual',
                    closeIconLabel: 'Cerrar panel',
                    sections: [
                        {
                            title: '¿Qué tipos de cookies tenemos? 🤔',
                            description: 'Puedes expresar tus preferencias relacionadas con el tratamiento de tus datos personales en este panel.<br> Para denegar tu consentimiento a las actividades de tratamiento específicas descritas a continuación, cambia los botones de activado a desactivado o utiliza el botón de “Rechazar todo” y confirma que deseas guardar tus elecciones.<br> Puedes revisar y modificar tus elecciones en cualquier momento volviendo a mostrar este panel a través del enlace "Configurar preferencias de cookies" proporcionado en el pie de la página web.'
                        },
                        {
                            title: 'Necesarias y funcionales 🛠',
                            description: 'Estas cookies se utilizan para actividades estrictamente necesarias para el funcionamiento o la prestación de los servicios que has solicitado, por lo que no requieren tu consentimiento.<br><br> Para más información, consulta el siguiente enlace: <a href="/politica-de-cookies/#necessary" rel="nofollow">Cookies necesarias y funcionales',
                            linkedCategory: 'necessary'
                        },
                        {
                            title: 'Estadísticas 📊',
                            description: 'Estas cookies nos permiten medir el tráfico y analizar cómo interactúas con nuestro servicio para mejorarlo continuamente.<br><br> Para más información, consulta el siguiente enlace: <a href="/politica-de-cookies/#analytics" rel="nofollow">Cookies para fines estadísticos</a>.',
                            linkedCategory: 'analytics'
                        },
                        {
                            title: '¿Qué es una cookie? 🍪',
                            description: 'Una cookie es un pequeño archivo de texto que se almacena en tu navegador cuando visitas casi cualquier página web. Su función principal es permitir que la web recuerde tu visita cuando vuelvas a navegar por ella.<br> Las cookies suelen almacenar información técnica, preferencias personales, personalización de contenidos, estadísticas de uso, enlaces a redes sociales, acceso a cuentas de usuario, entre otros.<br> Para más información detallada sobre nuestra política de cookies, puedes visitar el siguiente enlace: <a href="/politica-de-cookies" rel="nofollow">ver política de cookies</a>.'
                        }
                    ]
                }
            }
        }
    }
});