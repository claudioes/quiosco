<?php

/* /pedido/print-base.twig */
class __TwigTemplate_9254f81f4a9b5a81310c47ec928784c28faa4e5b6b6e37f25065da00173ffd61 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
            'content' => array($this, 'block_content'),
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo "<!DOCTYPE html>
<html lang=\"en\">
    <head>
        <meta charset=\"UTF-8\">
        <title>Pedido ";
        // line 5
        echo twig_escape_filter($this->env, $this->getAttribute(($context["pedido"] ?? null), "id", array()), "html", null, true);
        echo "</title>
        <style>
            body {
                margin: 0;
                padding: 0;
                font: normal 11px tahoma, helvetica, arial, sans-serif;
            }

            table {
            \tborder-collapse: collapse;
            \tborder-spacing: 0;
            }

            table th, td {
                padding: 4px;
            }

            table.cabecera {
                margin: 10px 0 10px 0;
            }

            table.cabecera td {
                vertical-align: top;
            }

            table.detalle tbody tr {
                border-bottom: solid 1px rgb(200, 200, 200);
            }

            table.detalle thead th {
                background-color: rgb(200, 200, 200);
                border: solid 2px rgb(100, 100, 100);
                padding: 5px;
            }

            table.detalle tfoot tr {
                border-bottom: none;
            }

            .nowrap {
                white-space: nowrap;
            }

            .text-right {
                text-align: right !important;
            }

            .text-center {
                text-align: center !important;
            }

            .w100 {
                width: 100%;
            }

            img.logo {
                width:100%;
            }

            div.container {
                width: 100%;
                height: 100%;
            }
        </style>
    </head>
    <body>
        <div class=\"container\">
            ";
        // line 72
        $this->displayBlock('content', $context, $blocks);
        // line 73
        echo "        </div>
    </body>
</html>
";
    }

    // line 72
    public function block_content($context, array $blocks = array())
    {
        echo " ";
    }

    public function getTemplateName()
    {
        return "/pedido/print-base.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  105 => 72,  98 => 73,  96 => 72,  26 => 5,  20 => 1,);
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
        <meta charset=\"UTF-8\">
        <title>Pedido {{ pedido.id }}</title>
        <style>
            body {
                margin: 0;
                padding: 0;
                font: normal 11px tahoma, helvetica, arial, sans-serif;
            }

            table {
            \tborder-collapse: collapse;
            \tborder-spacing: 0;
            }

            table th, td {
                padding: 4px;
            }

            table.cabecera {
                margin: 10px 0 10px 0;
            }

            table.cabecera td {
                vertical-align: top;
            }

            table.detalle tbody tr {
                border-bottom: solid 1px rgb(200, 200, 200);
            }

            table.detalle thead th {
                background-color: rgb(200, 200, 200);
                border: solid 2px rgb(100, 100, 100);
                padding: 5px;
            }

            table.detalle tfoot tr {
                border-bottom: none;
            }

            .nowrap {
                white-space: nowrap;
            }

            .text-right {
                text-align: right !important;
            }

            .text-center {
                text-align: center !important;
            }

            .w100 {
                width: 100%;
            }

            img.logo {
                width:100%;
            }

            div.container {
                width: 100%;
                height: 100%;
            }
        </style>
    </head>
    <body>
        <div class=\"container\">
            {% block content %} {% endblock %}
        </div>
    </body>
</html>
", "/pedido/print-base.twig", "G:\\www\\quiosco\\app\\Views\\pedido\\print-base.twig");
    }
}
