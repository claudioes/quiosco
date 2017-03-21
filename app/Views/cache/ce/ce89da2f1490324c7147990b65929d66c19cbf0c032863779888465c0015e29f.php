<?php

/* cliente/_tab_cc.twig */
class __TwigTemplate_8abdfe0836d9579cf2a17259ab042a7ceb1c003a1d97be6e05f9c87acd942622 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo "<div class=\"row\">
    <div class=\"form-group col-md-6\">
        <div class=\"input-group\">
            <div class=\"input-group-addon\">Desde</div>
            <input type=\"text\" class=\"form-control\" id=\"cc-desde\" value=\"\">
            <div class=\"input-group-addon\">
                <span class=\"glyphicon glyphicon-calendar\"></span>
            </div>
        </div>
    </div>
    <div class=\"form-group col-md-6\">
        <div class=\"input-group\">
            <div class=\"input-group-addon\">Hasta</div>
            <input type=\"text\" class=\"form-control\" id=\"cc-hasta\" value=\"\">
            <div class=\"input-group-addon\">
                <span class=\"glyphicon glyphicon-calendar\"></span>
            </div>
        </div>
    </div>
</div>

<div class=\"row\">
    <div class=\"form-group col-md-12\">
        <button id=\"mostrar-cc\" type=\"button\" class=\"btn btn-default\">
            <i class=\"glyphicon glyphicon-eye-open\"></i> Mostrar
        </button>
        <button id=\"imprimir-cc\" type=\"button\" class=\"btn btn-default\">
            <i class=\"glyphicon glyphicon-print\"></i> Imprimir
        </button>
    </div>
</div>

<div id=\"cc-tabla\" class=\"table-responsive\"></div>
";
    }

    public function getTemplateName()
    {
        return "cliente/_tab_cc.twig";
    }

    public function getDebugInfo()
    {
        return array (  19 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("<div class=\"row\">
    <div class=\"form-group col-md-6\">
        <div class=\"input-group\">
            <div class=\"input-group-addon\">Desde</div>
            <input type=\"text\" class=\"form-control\" id=\"cc-desde\" value=\"\">
            <div class=\"input-group-addon\">
                <span class=\"glyphicon glyphicon-calendar\"></span>
            </div>
        </div>
    </div>
    <div class=\"form-group col-md-6\">
        <div class=\"input-group\">
            <div class=\"input-group-addon\">Hasta</div>
            <input type=\"text\" class=\"form-control\" id=\"cc-hasta\" value=\"\">
            <div class=\"input-group-addon\">
                <span class=\"glyphicon glyphicon-calendar\"></span>
            </div>
        </div>
    </div>
</div>

<div class=\"row\">
    <div class=\"form-group col-md-12\">
        <button id=\"mostrar-cc\" type=\"button\" class=\"btn btn-default\">
            <i class=\"glyphicon glyphicon-eye-open\"></i> Mostrar
        </button>
        <button id=\"imprimir-cc\" type=\"button\" class=\"btn btn-default\">
            <i class=\"glyphicon glyphicon-print\"></i> Imprimir
        </button>
    </div>
</div>

<div id=\"cc-tabla\" class=\"table-responsive\"></div>
", "cliente/_tab_cc.twig", "G:\\www\\quiosco\\app\\Views\\cliente\\_tab_cc.twig");
    }
}
