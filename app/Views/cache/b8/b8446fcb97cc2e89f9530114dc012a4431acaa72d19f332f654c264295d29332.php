<?php

/* template/base.twig */
class __TwigTemplate_65080e7255391028328db2e4052fabb72a0d598cc4fbb8c5beadc1a712ab491c extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
            'jslib' => array($this, 'block_jslib'),
            'css' => array($this, 'block_css'),
            'content' => array($this, 'block_content'),
            'jsapp' => array($this, 'block_jsapp'),
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo "<!DOCTYPE html>
<html lang=\"en\">
<head>
    <meta charset=\"utf-8\">
    <meta name=\"description\" content=\"\">
    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">
    <link rel='shortcut icon' type='image/x-icon' href='favicon.ico' />
    <title>";
        // line 8
        echo twig_escape_filter($this->env, $this->getAttribute(($context["app"] ?? null), "name", array()), "html", null, true);
        echo "</title>

    <link rel=\"stylesheet\" href=\"https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css\">
    <link rel=\"stylesheet\" href=\"https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css\">
    <link rel=\"stylesheet\" href=\"";
        // line 12
        echo twig_escape_filter($this->env, $this->env->getExtension('Slim\Views\TwigExtension')->site("css/lib/datatables/dataTables.bootstrap.min.css"), "html", null, true);
        echo "\">
    <link rel=\"stylesheet\" href=\"";
        // line 13
        echo twig_escape_filter($this->env, $this->env->getExtension('Slim\Views\TwigExtension')->site("css/lib/selectize/selectize.bootstrap3.css"), "html", null, true);
        echo "\">
    <link rel=\"stylesheet\" href=\"";
        // line 14
        echo twig_escape_filter($this->env, $this->env->getExtension('Slim\Views\TwigExtension')->site("css/lib/toastr.css"), "html", null, true);
        echo "\">
    <link rel=\"stylesheet\" href=\"";
        // line 15
        echo twig_escape_filter($this->env, $this->env->getExtension('Slim\Views\TwigExtension')->site("css/lib/datepicker/bootstrap-datepicker3.min.css"), "html", null, true);
        echo "\">
    <link rel=\"stylesheet\" href=\"";
        // line 16
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('siteUrlWithVersion')->getCallable(), array("css/app/main.css")), "html", null, true);
        echo "\">
    <link rel=\"stylesheet\" href=\"";
        // line 17
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('siteUrlWithVersion')->getCallable(), array("css/app/sidebar.css")), "html", null, true);
        echo "\">

    ";
        // line 19
        $this->displayBlock('jslib', $context, $blocks);
        // line 40
        echo "
    ";
        // line 41
        $this->displayBlock('css', $context, $blocks);
        // line 42
        echo "</head>
<body>
    ";
        // line 44
        $this->loadTemplate("template/menu.twig", "template/base.twig", 44)->display($context);
        // line 45
        echo "    ";
        $this->loadTemplate("template/sidebar.twig", "template/base.twig", 45)->display($context);
        // line 46
        echo "
    <div class=\"main-content\">
        <div class=\"container-fluid\">
            ";
        // line 49
        if ($this->getAttribute(($context["flash"] ?? null), "success", array())) {
            // line 50
            echo "                <div class=\"alert alert-success alert-dismissable\" role=\"alert\" id=\"mensaje\">
                    <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">
                        <span aria-hidden=\"true\">&times;</span>
                    </button>
                    ";
            // line 54
            echo twig_escape_filter($this->env, $this->getAttribute(($context["flash"] ?? null), "success", array()), "html", null, true);
            echo "
                </div>
            ";
        }
        // line 57
        echo "
            ";
        // line 58
        $this->displayBlock('content', $context, $blocks);
        // line 59
        echo "        </div>
    </div>

    <script>
        var Router = function(root) {
            this.base = '";
        // line 64
        echo twig_escape_filter($this->env, $this->env->getExtension('Slim\Views\TwigExtension')->base(), "html", null, true);
        echo "/';
            this.root = this.base + root;
            this.urlFor = function(resource, params) {
                var absolutePath = this.root;
                if (resource && String(resource).substring(0, 1) == '/') {
                    resource = String(resource).substring(1);
                }
                if (resource) {
                    absolutePath += '/' + resource;
                }
                if (params) {
                    absolutePath += '?' + \$.param(params);
                }
                return absolutePath;
            };
        };

        \$(function() {
            \$('[data-toggle=\"tooltip\"]').tooltip();
        });

        var App = {
            basePath: '";
        // line 86
        echo twig_escape_filter($this->env, $this->env->getExtension('Slim\Views\TwigExtension')->base(), "html", null, true);
        echo "',
            pathFor: function (resource, params) {
                if (typeof resource != 'undefined' && String(resource).substring(0, 1) == '/') {
                    resource = String(resource).substring(1);
                }

                if (typeof params != 'undefined') {
                    params = \$.param(params);
                }

                return '";
        // line 96
        echo twig_escape_filter($this->env, $this->env->getExtension('Slim\Views\TwigExtension')->base(), "html", null, true);
        echo "/' + resource + (params? '?' + params: '') ;
            },
        };
    </script>

    ";
        // line 101
        $this->displayBlock('jsapp', $context, $blocks);
        // line 102
        echo "</body>
</html>
";
    }

    // line 19
    public function block_jslib($context, array $blocks = array())
    {
        // line 20
        echo "        <script src=\"https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js\"></script>
        <script src=\"https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js\"></script>
        <script src=\"";
        // line 22
        echo twig_escape_filter($this->env, $this->env->getExtension('Slim\Views\TwigExtension')->site("js/lib/datatables/jquery.dataTables.min.js"), "html", null, true);
        echo "\"></script>
        <script src=\"";
        // line 23
        echo twig_escape_filter($this->env, $this->env->getExtension('Slim\Views\TwigExtension')->site("js/lib/datatables/dataTables.bootstrap.min.js"), "html", null, true);
        echo "\"></script>
        <script src=\"";
        // line 24
        echo twig_escape_filter($this->env, $this->env->getExtension('Slim\Views\TwigExtension')->site("js/lib/selectize/standalone/selectize.min.js"), "html", null, true);
        echo "\"></script>
        <script src=\"";
        // line 25
        echo twig_escape_filter($this->env, $this->env->getExtension('Slim\Views\TwigExtension')->site("js/lib/bootbox.min.js"), "html", null, true);
        echo "\"></script>
        <script src=\"";
        // line 26
        echo twig_escape_filter($this->env, $this->env->getExtension('Slim\Views\TwigExtension')->site("js/lib/toastr.min.js"), "html", null, true);
        echo "\"></script>
        <script src=\"";
        // line 27
        echo twig_escape_filter($this->env, $this->env->getExtension('Slim\Views\TwigExtension')->site("js/lib/validation/jquery.validate.min.js"), "html", null, true);
        echo "\"></script>
        <script src=\"";
        // line 28
        echo twig_escape_filter($this->env, $this->env->getExtension('Slim\Views\TwigExtension')->site("js/lib/validation/localization/messages_es.min.js"), "html", null, true);
        echo "\"></script>
        <script src=\"";
        // line 29
        echo twig_escape_filter($this->env, $this->env->getExtension('Slim\Views\TwigExtension')->site("js/lib/validation/additional-methods.min.js"), "html", null, true);
        echo "\"></script>
        <script src=\"";
        // line 30
        echo twig_escape_filter($this->env, $this->env->getExtension('Slim\Views\TwigExtension')->site("js/lib/datepicker/bootstrap-datepicker.min.js"), "html", null, true);
        echo "\"></script>
        <script src=\"";
        // line 31
        echo twig_escape_filter($this->env, $this->env->getExtension('Slim\Views\TwigExtension')->site("js/lib/datepicker/locales/bootstrap-datepicker.es.min.js"), "html", null, true);
        echo "\"></script>
        <script src=\"";
        // line 32
        echo twig_escape_filter($this->env, $this->env->getExtension('Slim\Views\TwigExtension')->site("js/lib/tinymce/tinymce.min.js"), "html", null, true);
        echo "\"></script>
        <script src=\"";
        // line 33
        echo twig_escape_filter($this->env, $this->env->getExtension('Slim\Views\TwigExtension')->site("js/lib/tinymce/langs/es.js"), "html", null, true);
        echo "\"></script>
        <!-- <script src=\"";
        // line 34
        echo twig_escape_filter($this->env, $this->env->getExtension('Slim\Views\TwigExtension')->site("js/lib/chart.min.js"), "html", null, true);
        echo " }}\"></script> -->

        <script src=\"";
        // line 36
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('siteUrlWithVersion')->getCallable(), array("js/app/defaults.js")), "html", null, true);
        echo "\"></script>
        <script src=\"";
        // line 37
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('siteUrlWithVersion')->getCallable(), array("js/app/common.js")), "html", null, true);
        echo "\"></script>
        <script src=\"";
        // line 38
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('siteUrlWithVersion')->getCallable(), array("js/app/message.js")), "html", null, true);
        echo "\"></script>
    ";
    }

    // line 41
    public function block_css($context, array $blocks = array())
    {
        echo " ";
    }

    // line 58
    public function block_content($context, array $blocks = array())
    {
        echo " ";
    }

    // line 101
    public function block_jsapp($context, array $blocks = array())
    {
        echo " ";
    }

    public function getTemplateName()
    {
        return "template/base.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  251 => 101,  245 => 58,  239 => 41,  233 => 38,  229 => 37,  225 => 36,  220 => 34,  216 => 33,  212 => 32,  208 => 31,  204 => 30,  200 => 29,  196 => 28,  192 => 27,  188 => 26,  184 => 25,  180 => 24,  176 => 23,  172 => 22,  168 => 20,  165 => 19,  159 => 102,  157 => 101,  149 => 96,  136 => 86,  111 => 64,  104 => 59,  102 => 58,  99 => 57,  93 => 54,  87 => 50,  85 => 49,  80 => 46,  77 => 45,  75 => 44,  71 => 42,  69 => 41,  66 => 40,  64 => 19,  59 => 17,  55 => 16,  51 => 15,  47 => 14,  43 => 13,  39 => 12,  32 => 8,  23 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("<!DOCTYPE html>
<html lang=\"en\">
<head>
    <meta charset=\"utf-8\">
    <meta name=\"description\" content=\"\">
    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">
    <link rel='shortcut icon' type='image/x-icon' href='favicon.ico' />
    <title>{{ app.name }}</title>

    <link rel=\"stylesheet\" href=\"https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css\">
    <link rel=\"stylesheet\" href=\"https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css\">
    <link rel=\"stylesheet\" href=\"{{ siteUrl('css/lib/datatables/dataTables.bootstrap.min.css') }}\">
    <link rel=\"stylesheet\" href=\"{{ siteUrl('css/lib/selectize/selectize.bootstrap3.css') }}\">
    <link rel=\"stylesheet\" href=\"{{ siteUrl('css/lib/toastr.css') }}\">
    <link rel=\"stylesheet\" href=\"{{ siteUrl('css/lib/datepicker/bootstrap-datepicker3.min.css') }}\">
    <link rel=\"stylesheet\" href=\"{{ siteUrlWithVersion('css/app/main.css') }}\">
    <link rel=\"stylesheet\" href=\"{{ siteUrlWithVersion('css/app/sidebar.css') }}\">

    {% block jslib %}
        <script src=\"https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js\"></script>
        <script src=\"https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js\"></script>
        <script src=\"{{ siteUrl('js/lib/datatables/jquery.dataTables.min.js') }}\"></script>
        <script src=\"{{ siteUrl('js/lib/datatables/dataTables.bootstrap.min.js') }}\"></script>
        <script src=\"{{ siteUrl('js/lib/selectize/standalone/selectize.min.js') }}\"></script>
        <script src=\"{{ siteUrl('js/lib/bootbox.min.js') }}\"></script>
        <script src=\"{{ siteUrl('js/lib/toastr.min.js') }}\"></script>
        <script src=\"{{ siteUrl('js/lib/validation/jquery.validate.min.js') }}\"></script>
        <script src=\"{{ siteUrl('js/lib/validation/localization/messages_es.min.js') }}\"></script>
        <script src=\"{{ siteUrl('js/lib/validation/additional-methods.min.js') }}\"></script>
        <script src=\"{{ siteUrl('js/lib/datepicker/bootstrap-datepicker.min.js') }}\"></script>
        <script src=\"{{ siteUrl('js/lib/datepicker/locales/bootstrap-datepicker.es.min.js') }}\"></script>
        <script src=\"{{ siteUrl('js/lib/tinymce/tinymce.min.js') }}\"></script>
        <script src=\"{{ siteUrl('js/lib/tinymce/langs/es.js') }}\"></script>
        <!-- <script src=\"{{ siteUrl('js/lib/chart.min.js') }} }}\"></script> -->

        <script src=\"{{ siteUrlWithVersion('js/app/defaults.js') }}\"></script>
        <script src=\"{{ siteUrlWithVersion('js/app/common.js') }}\"></script>
        <script src=\"{{ siteUrlWithVersion('js/app/message.js') }}\"></script>
    {% endblock %}

    {% block css %} {% endblock %}
</head>
<body>
    {% include 'template/menu.twig' %}
    {% include 'template/sidebar.twig' %}

    <div class=\"main-content\">
        <div class=\"container-fluid\">
            {% if flash.success %}
                <div class=\"alert alert-success alert-dismissable\" role=\"alert\" id=\"mensaje\">
                    <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">
                        <span aria-hidden=\"true\">&times;</span>
                    </button>
                    {{ flash.success }}
                </div>
            {% endif %}

            {% block content %} {% endblock %}
        </div>
    </div>

    <script>
        var Router = function(root) {
            this.base = '{{ baseUrl() }}/';
            this.root = this.base + root;
            this.urlFor = function(resource, params) {
                var absolutePath = this.root;
                if (resource && String(resource).substring(0, 1) == '/') {
                    resource = String(resource).substring(1);
                }
                if (resource) {
                    absolutePath += '/' + resource;
                }
                if (params) {
                    absolutePath += '?' + \$.param(params);
                }
                return absolutePath;
            };
        };

        \$(function() {
            \$('[data-toggle=\"tooltip\"]').tooltip();
        });

        var App = {
            basePath: '{{ baseUrl() }}',
            pathFor: function (resource, params) {
                if (typeof resource != 'undefined' && String(resource).substring(0, 1) == '/') {
                    resource = String(resource).substring(1);
                }

                if (typeof params != 'undefined') {
                    params = \$.param(params);
                }

                return '{{ baseUrl() }}/' + resource + (params? '?' + params: '') ;
            },
        };
    </script>

    {% block jsapp %} {% endblock %}
</body>
</html>
", "template/base.twig", "G:\\www\\quiosco\\app\\Views\\template\\base.twig");
    }
}
