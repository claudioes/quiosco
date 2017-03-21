<?php

/* pedido/form.twig */
class __TwigTemplate_e9cd761a9b134dbf65e19146fcf1792507f82c0019aa7bc7dc7d75e4d5096fa5 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 2
        $this->parent = $this->loadTemplate("template/base.twig", "pedido/form.twig", 2);
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
        $context["form"] = $this->loadTemplate("template/macro/form.twig", "pedido/form.twig", 1);
        // line 2
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 4
    public function block_jsapp($context, array $blocks = array())
    {
        // line 5
        echo "    <script src=\"";
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('siteUrlWithVersion')->getCallable(), array("js/app/modal.js")), "html", null, true);
        echo "\"></script>
    <script src=\"";
        // line 6
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('siteUrlWithVersion')->getCallable(), array("js/app/pedido.js")), "html", null, true);
        echo "\"></script>
    <script>
        \$(function () {
            App.Pedido.Form();
        })
    </script>
";
    }

    // line 14
    public function block_content($context, array $blocks = array())
    {
        // line 15
        echo "    <h1>Nuevo pedido</h1>

    <div class=\"alert alert-danger\" role=\"alert\" id=\"mensaje\" style=\"display:none\"></div>

    <form id=\"form\" action=\"";
        // line 19
        echo twig_escape_filter($this->env, $this->env->getExtension('Slim\Views\TwigExtension')->urlFor("Pedido:save"), "html", null, true);
        echo "\" method=\"post\">
        <div class=\"row\">
            <div class=\"col-md-3\">
                <div class=\"panel panel-default\">
                    <div class=\"panel-body\">
                        <div class=\"form-group\">
                            ";
        // line 25
        echo $context["form"]->getlabel("cliente", "Cliente", array("class" => "control-label"));
        echo "
                            <select id=\"cliente\" name=\"cliente\" class=\"form-control\">
                                <option></option>
                                ";
        // line 28
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["clientes"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["cliente"]) {
            // line 29
            echo "                                    <option value=\"";
            echo twig_escape_filter($this->env, $this->getAttribute($context["cliente"], "id", array()), "html", null, true);
            echo "\">(";
            echo twig_escape_filter($this->env, $this->getAttribute($context["cliente"], "codigo", array()), "html", null, true);
            echo ") ";
            echo twig_escape_filter($this->env, $this->getAttribute($context["cliente"], "nombre", array()), "html", null, true);
            echo "</option>
                                ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['cliente'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 31
        echo "                            </select>
                        </div>
                        <div id=\"info-cliente\"></div>
                    </div>
                </div>
            </div>
            <div class=\"col-md-9\">
                <div class=\"panel panel-default\">
                    <div class=\"table-responsive\">
                        <table id=\"lineas\" class=\"table\">
                            <thead>
                                <tr>
                                    <th width=\"200px\">Código</th>
                                    <th>Descripción</th>
                                    <th width=\"100px\">Cantidad</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                            <tfoot>
                                <tr>
                                    <td colspan=\"3\">
                                        <div class=\"input-group\">
                                            <input type=\"text\" class=\"form-control\" id=\"codigo\" placeholder=\"Buscar\">
                                            <span class=\"input-group-btn\">
                                                <button class=\"btn btn-default\" type=\"button\" id=\"btn-buscar-articulo\"><i class=\"glyphicon glyphicon-search\"></i></button>
                                            </span>
                                        </div>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class=\"row\">
            <div class=\"form-group col-md-12\">
                <button id=\"btn-ok\" type=\"submit\" class=\"btn btn-success\" style=\"margin-right: 15px;\"><i class=\"glyphicon glyphicon-ok\"></i> Guardar</button>
                <a href=\"#\" onclick=\"history.back();\">Cancelar</a>
            </div>
        </div>
    </form>
";
    }

    public function getTemplateName()
    {
        return "pedido/form.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  92 => 31,  79 => 29,  75 => 28,  69 => 25,  60 => 19,  54 => 15,  51 => 14,  40 => 6,  35 => 5,  32 => 4,  28 => 2,  26 => 1,  11 => 2,);
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
    <script src=\"{{ siteUrlWithVersion('js/app/modal.js') }}\"></script>
    <script src=\"{{ siteUrlWithVersion('js/app/pedido.js') }}\"></script>
    <script>
        \$(function () {
            App.Pedido.Form();
        })
    </script>
{% endblock %}

{% block content %}
    <h1>Nuevo pedido</h1>

    <div class=\"alert alert-danger\" role=\"alert\" id=\"mensaje\" style=\"display:none\"></div>

    <form id=\"form\" action=\"{{ urlFor('Pedido:save') }}\" method=\"post\">
        <div class=\"row\">
            <div class=\"col-md-3\">
                <div class=\"panel panel-default\">
                    <div class=\"panel-body\">
                        <div class=\"form-group\">
                            {{ form.label('cliente', 'Cliente', { class: 'control-label' }) }}
                            <select id=\"cliente\" name=\"cliente\" class=\"form-control\">
                                <option></option>
                                {% for cliente in clientes %}
                                    <option value=\"{{ cliente.id }}\">({{ cliente.codigo }}) {{ cliente.nombre }}</option>
                                {% endfor %}
                            </select>
                        </div>
                        <div id=\"info-cliente\"></div>
                    </div>
                </div>
            </div>
            <div class=\"col-md-9\">
                <div class=\"panel panel-default\">
                    <div class=\"table-responsive\">
                        <table id=\"lineas\" class=\"table\">
                            <thead>
                                <tr>
                                    <th width=\"200px\">Código</th>
                                    <th>Descripción</th>
                                    <th width=\"100px\">Cantidad</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                            <tfoot>
                                <tr>
                                    <td colspan=\"3\">
                                        <div class=\"input-group\">
                                            <input type=\"text\" class=\"form-control\" id=\"codigo\" placeholder=\"Buscar\">
                                            <span class=\"input-group-btn\">
                                                <button class=\"btn btn-default\" type=\"button\" id=\"btn-buscar-articulo\"><i class=\"glyphicon glyphicon-search\"></i></button>
                                            </span>
                                        </div>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class=\"row\">
            <div class=\"form-group col-md-12\">
                <button id=\"btn-ok\" type=\"submit\" class=\"btn btn-success\" style=\"margin-right: 15px;\"><i class=\"glyphicon glyphicon-ok\"></i> Guardar</button>
                <a href=\"#\" onclick=\"history.back();\">Cancelar</a>
            </div>
        </div>
    </form>
{% endblock %}
", "pedido/form.twig", "G:\\www\\quiosco\\app\\Views\\pedido\\form.twig");
    }
}
