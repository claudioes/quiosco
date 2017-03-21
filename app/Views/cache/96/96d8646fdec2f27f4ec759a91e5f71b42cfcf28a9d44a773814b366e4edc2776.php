<?php

/* articulo/aumento.twig */
class __TwigTemplate_bd168153f50060068bc78529a787b5954b3dfe9013e5607c96f6d36310676659 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 2
        $this->parent = $this->loadTemplate("template/base.twig", "articulo/aumento.twig", 2);
        $this->blocks = array(
            'jsapp' => array($this, 'block_jsapp'),
            'content' => array($this, 'block_content'),
        );
    }

    protected function doGetParent(array $context)
    {
        return "template/base.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        $context["form"] = $this->loadTemplate("template/macro/form.twig", "articulo/aumento.twig", 1);
        // line 2
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 4
    public function block_jsapp($context, array $blocks = array())
    {
        // line 5
        echo "    <script src=\"";
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('siteUrlWithVersion')->getCallable(), array("js/app/articulo.js")), "html", null, true);
        echo "\"></script>
    <script>
        \$(function () {
            App.Articulo.Aumento();
        })
    </script>
";
    }

    // line 13
    public function block_content($context, array $blocks = array())
    {
        // line 14
        echo "<h1>Aumentos</h1>
<div class=\"alert alert-danger\" role=\"alert\" id=\"mensaje\" style=\"display:none\"></div>
<form class=\"form\" id=\"form\" action=\"";
        // line 16
        echo twig_escape_filter($this->env, $this->env->getExtension('Slim\Views\TwigExtension')->urlFor("Articulo:aumento"), "html", null, true);
        echo "\" method=\"post\" autocomplete:\"off\">
    <div class=\"panel panel-default\">
        <div class=\"panel-body\">
            <div class=\"col-lg-6\">
                <div class=\"row\">
                    <div class=\"form-group col-sm-8 required\" >
                        ";
        // line 22
        echo $context["form"]->getlabel("accion", "Acción", array("class" => "control-label"));
        echo "
                        ";
        // line 23
        echo $context["form"]->getselect("accion", ($context["opciones"] ?? null), null, array("class" => "form-control", "required" => "", "autofocus" => ""));
        echo "
                    </div>
                    <div class=\"form-group col-sm-4\" id=\"div-valor\">
                        ";
        // line 26
        echo $context["form"]->getlabel("valor", "Porcentaje", array("class" => "control-label", "id" => "label-valor"));
        echo "
                        ";
        // line 27
        echo $context["form"]->gettext("valor", null, array("class" => "form-control", "required" => ""));
        echo "
                    </div>
                </div>
                <div class=\"row\">
                    <div class=\"form-group col-sm-12\">
                        ";
        // line 32
        echo $context["form"]->getlabel("marca", "Marca", array("class" => "control-label"));
        echo "
                        <select id=\"marca\" name=\"marca\" class=\"form-control selectize\">
                            <option value=\"\" selected>Todas las marcas</option>
                            ";
        // line 35
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["marcas"] ?? null));
        foreach ($context['_seq'] as $context["key"] => $context["name"]) {
            // line 36
            echo "                                <option value=\"";
            echo twig_escape_filter($this->env, $context["key"], "html", null, true);
            echo "\">";
            echo twig_escape_filter($this->env, $context["name"], "html", null, true);
            echo "</option>
                            ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['key'], $context['name'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 38
        echo "                        </select>
                    </div>
                </div>
                <div class=\"row\">
                    <div class=\"form-group col-sm-12\">
                        ";
        // line 43
        echo $context["form"]->getlabel("familia", "Familia", array("class" => "control-label"));
        echo "
                        <select id=\"familia\" name=\"familia\" class=\"form-control selectize\">
                            <option value=\"\" selected>Todas las familias</option>
                            ";
        // line 46
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["familias"] ?? null));
        foreach ($context['_seq'] as $context["key"] => $context["name"]) {
            // line 47
            echo "                                <option value=\"";
            echo twig_escape_filter($this->env, $context["key"], "html", null, true);
            echo "\">";
            echo twig_escape_filter($this->env, $context["name"], "html", null, true);
            echo "</option>
                            ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['key'], $context['name'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 49
        echo "                        </select>
                    </div>
                </div>
                <div class=\"row\">
                    <div class=\"form-group col-sm-12\">
                        ";
        // line 54
        echo $context["form"]->getlabel("proveedor", "Proveedor", array("class" => "control-label"));
        echo "
                        <select id=\"proveedor\" name=\"proveedor\" class=\"form-control selectize\">
                            <option value=\"\" selected>Todos los proveedores</option>
                            ";
        // line 57
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["proveedores"] ?? null));
        foreach ($context['_seq'] as $context["key"] => $context["name"]) {
            // line 58
            echo "                                <option value=\"";
            echo twig_escape_filter($this->env, $context["key"], "html", null, true);
            echo "\">";
            echo twig_escape_filter($this->env, $context["name"], "html", null, true);
            echo "</option>
                            ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['key'], $context['name'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 60
        echo "                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class=\"panel-footer\">
            <button type=\"submit\" class=\"btn btn-success\" style=\"margin-right: 10px;\">Aceptar</button>
            <a href=\"#\" onclick=\"history.back();\">Cancelar</a>
        </div>
    </div>
</form>
";
    }

    public function getTemplateName()
    {
        return "articulo/aumento.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  162 => 60,  151 => 58,  147 => 57,  141 => 54,  134 => 49,  123 => 47,  119 => 46,  113 => 43,  106 => 38,  95 => 36,  91 => 35,  85 => 32,  77 => 27,  73 => 26,  67 => 23,  63 => 22,  54 => 16,  50 => 14,  47 => 13,  35 => 5,  32 => 4,  28 => 2,  26 => 1,  11 => 2,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("{% import \"template/macro/form.twig\" as form %}
{% extends \"template/base.twig\" %}

{% block jsapp %}
    <script src=\"{{ siteUrlWithVersion('js/app/articulo.js') }}\"></script>
    <script>
        \$(function () {
            App.Articulo.Aumento();
        })
    </script>
{% endblock %}

{% block content %}
<h1>Aumentos</h1>
<div class=\"alert alert-danger\" role=\"alert\" id=\"mensaje\" style=\"display:none\"></div>
<form class=\"form\" id=\"form\" action=\"{{ urlFor('Articulo:aumento') }}\" method=\"post\" autocomplete:\"off\">
    <div class=\"panel panel-default\">
        <div class=\"panel-body\">
            <div class=\"col-lg-6\">
                <div class=\"row\">
                    <div class=\"form-group col-sm-8 required\" >
                        {{ form.label('accion', 'Acción', { class:'control-label' }) }}
                        {{ form.select('accion', opciones, null, { class:'form-control', required:'', autofocus:'' }) }}
                    </div>
                    <div class=\"form-group col-sm-4\" id=\"div-valor\">
                        {{ form.label('valor', 'Porcentaje', { class:'control-label', id:'label-valor' }) }}
                        {{ form.text('valor', null, { class:'form-control', required:'' }) }}
                    </div>
                </div>
                <div class=\"row\">
                    <div class=\"form-group col-sm-12\">
                        {{ form.label('marca', 'Marca', { class:'control-label' }) }}
                        <select id=\"marca\" name=\"marca\" class=\"form-control selectize\">
                            <option value=\"\" selected>Todas las marcas</option>
                            {% for key, name in marcas %}
                                <option value=\"{{ key }}\">{{ name }}</option>
                            {% endfor %}
                        </select>
                    </div>
                </div>
                <div class=\"row\">
                    <div class=\"form-group col-sm-12\">
                        {{ form.label('familia', 'Familia', { class:'control-label' }) }}
                        <select id=\"familia\" name=\"familia\" class=\"form-control selectize\">
                            <option value=\"\" selected>Todas las familias</option>
                            {% for key, name in familias %}
                                <option value=\"{{ key }}\">{{ name }}</option>
                            {% endfor %}
                        </select>
                    </div>
                </div>
                <div class=\"row\">
                    <div class=\"form-group col-sm-12\">
                        {{ form.label('proveedor', 'Proveedor', { class:'control-label' }) }}
                        <select id=\"proveedor\" name=\"proveedor\" class=\"form-control selectize\">
                            <option value=\"\" selected>Todos los proveedores</option>
                            {% for key, name in proveedores %}
                                <option value=\"{{ key }}\">{{ name }}</option>
                            {% endfor %}
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class=\"panel-footer\">
            <button type=\"submit\" class=\"btn btn-success\" style=\"margin-right: 10px;\">Aceptar</button>
            <a href=\"#\" onclick=\"history.back();\">Cancelar</a>
        </div>
    </div>
</form>
{% endblock %}
", "articulo/aumento.twig", "G:\\www\\quiosco\\app\\Views\\articulo\\aumento.twig");
    }
}
