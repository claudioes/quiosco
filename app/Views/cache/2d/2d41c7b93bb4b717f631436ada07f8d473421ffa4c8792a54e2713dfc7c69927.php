<?php

/* articulo/form.twig */
class __TwigTemplate_47384424669aeb7f5f16538aa0ed22a1a42015814eb7caf7df73d8b8b627c9f2 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 2
        $this->parent = $this->loadTemplate("template/base.twig", "articulo/form.twig", 2);
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
        $context["form"] = $this->loadTemplate("template/macro/form.twig", "articulo/form.twig", 1);
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
            App.Articulo.Form();
        })
    </script>
";
    }

    // line 13
    public function block_content($context, array $blocks = array())
    {
        // line 14
        echo "    <h1>";
        echo ((($context["articulo"] ?? null)) ? ("Modificando") : ("Nuevo"));
        echo " artículo</h1>

    <div class=\"alert alert-danger\" role=\"alert\" id=\"mensaje\" style=\"display:none\"></div>

    <div class=\"row\">
        <div class=\"col-md-6\">
            <form class=\"form\" id=\"form\" action=\"";
        // line 20
        echo twig_escape_filter($this->env, $this->env->getExtension('Slim\Views\TwigExtension')->urlFor("Articulo:save"), "html", null, true);
        echo "\" method=\"post\" autocomplete=\"off\">
                ";
        // line 21
        if (($context["articulo"] ?? null)) {
            // line 22
            echo "                    ";
            echo $context["form"]->gethidden("id", $this->getAttribute(($context["articulo"] ?? null), "id", array()));
            echo "
                ";
        }
        // line 24
        echo "
                <div class=\"panel panel-default\">
                    <div class=\"panel-body\">
                        <fieldset>
                            <div class=\"row\">
                                <div class=\"form-group required col-md-2\">
                                    ";
        // line 30
        echo $context["form"]->getlabel("codigo", "Código", array("class" => "control-label"));
        echo "
                                    ";
        // line 31
        echo $context["form"]->gettext("codigo", $this->getAttribute(($context["articulo"] ?? null), "codigo", array()), array("class" => "form-control", "required" => "", "autofocus" => ""));
        echo "
                                </div>
                                <div class=\"form-group required col-md-10\">
                                    ";
        // line 34
        echo $context["form"]->getlabel("descripcion", "Descripción", array("class" => "control-label"));
        echo "
                                    ";
        // line 35
        echo $context["form"]->gettext("descripcion", $this->getAttribute(($context["articulo"] ?? null), "descripcion", array()), array("class" => "form-control", "required" => ""));
        echo "
                                </div>
                            </div>

                            <div class=\"row\">
                                <div class=\"form-group required col-md-12\">
                                    ";
        // line 41
        echo $context["form"]->getlabel("marca", "Marca", array("class" => "control-label"));
        echo "
                                    ";
        // line 42
        echo $context["form"]->getselect("marca", ($context["marcas"] ?? null), $this->getAttribute(($context["articulo"] ?? null), "marca_id", array()), array("class" => "form-control", "required" => ""));
        echo "
                                </div>
                            </div>

                            <div class=\"row\">
                                <div class=\"form-group required col-md-12\">
                                    ";
        // line 48
        echo $context["form"]->getlabel("familia", "Familia", array("class" => "control-label"));
        echo "
                                    ";
        // line 49
        echo $context["form"]->getselect("familia", ($context["familias"] ?? null), $this->getAttribute(($context["articulo"] ?? null), "familia_id", array()), array("class" => "form-control", "required" => ""));
        echo "
                                </div>
                            </div>

                            <div class=\"row\">
                                <div class=\"form-group required col-md-12\">
                                    ";
        // line 55
        echo $context["form"]->getlabel("proveedor", "Proveedor", array("class" => "control-label"));
        echo "
                                    ";
        // line 56
        echo $context["form"]->getselect("proveedor", ($context["proveedores"] ?? null), $this->getAttribute(($context["articulo"] ?? null), "proveedor_id", array()), array("class" => "form-control", "required" => ""));
        echo "
                                </div>
                            </div>
                        </fieldset>

                        <fieldset>
                            <div class=\"row\">
                                <div class=\"form-group col-md-4\">
                                    ";
        // line 64
        echo $context["form"]->getlabel("costo", "Costo", array("class" => "control-label"));
        echo "
                                    <div class=\"input-group\">
                                        <span class=\"input-group-addon\">\$</span>
                                        ";
        // line 67
        echo $context["form"]->gettext("costo", $this->getAttribute(($context["articulo"] ?? null), "costo", array()), array("class" => "form-control calcular", "placeholder" => "0.00"));
        echo "
                                    </div>
                                </div>
                                <div class=\"form-group col-md-4\">
                                    ";
        // line 71
        echo $context["form"]->getlabel("ganancia", "Ganancia", array("class" => "control-label"));
        echo "
                                    <div class=\"input-group\">
                                        <span class=\"input-group-addon\">%</span>
                                        ";
        // line 74
        echo $context["form"]->gettext("ganancia", $this->getAttribute(($context["articulo"] ?? null), "ganancia", array()), array("class" => "form-control calcular", "placeholder" => "0.00"));
        echo "
                                    </div>
                                </div>
                                <div class=\"form-group col-md-4\">
                                    ";
        // line 78
        echo $context["form"]->getlabel("precio", "Precio de venta", array("class" => "control-label"));
        echo "
                                    <div class=\"input-group\">
                                        <span class=\"input-group-addon\">%</span>
                                        ";
        // line 81
        echo $context["form"]->gettext("precio", $this->getAttribute(($context["articulo"] ?? null), "precio", array()), array("class" => "form-control", "placeholder" => "0.00"));
        echo "
                                    </div>
                                </div>
                            </div>
                        </fieldset>

                        <fieldset>
                            <div class=\"row\">
                                <div class=\"form-group col-md-4\">
                                    ";
        // line 90
        echo $context["form"]->getlabel("minimo", "Mínimo", array("class" => "control-label"));
        echo "
                                    ";
        // line 91
        echo $context["form"]->gettext("minimo", $this->getAttribute(($context["articulo"] ?? null), "stock_minimo", array()), array("class" => "form-control", "placeholder" => "0.00"));
        echo "
                                </div>
                            </div>
                            <div class=\"row\">
                                <div class=\"form-group col-md-12\">
                                    ";
        // line 96
        echo $context["form"]->getlabel("notas", "Notas", array("class" => "control-label"));
        echo "
                                    ";
        // line 97
        echo $context["form"]->gettextarea("notas", $this->getAttribute(($context["articulo"] ?? null), "notas", array()), array("class" => "form-control", "rows" => "4"));
        echo "
                                </div>
                            </div>
                        </fieldset>
                    </div>
                    <div class=\"panel-footer\">
                        <button type=\"submit\" class=\"btn btn-success\" style=\"margin-right: 1em;\"><i class=\"glyphicon glyphicon-ok\" style=\"margin-right: 0.5em;\"></i>Guardar</button>
                        <a href=\"#\" onclick=\"history.back();\">Cancelar</a>
                    </div>
                </div>
            </form>
        </div>
        <div class=\"col-md-6\">
            ";
        // line 110
        if ( !(null === ($context["articulo"] ?? null))) {
            // line 111
            echo "                <div class=\"panel panel-default\">
                    <div class=\"panel-heading\">
                        Stock
                    </div>
                    <div class=\"panel-body\">
                        <table class=\"table table-bordered\">
                            <thead>
                                <tr>
                                    <th>Deposito</th>
                                    <th>Cantidad</th>
                                </tr>
                            </thead>
                            <tbody>
                                ";
            // line 124
            $context["total"] = 0;
            // line 125
            echo "                                ";
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable(($context["stock"] ?? null));
            foreach ($context['_seq'] as $context["_key"] => $context["deposito"]) {
                // line 126
                echo "                                    <tr>
                                        <td>";
                // line 127
                echo twig_escape_filter($this->env, $this->getAttribute($context["deposito"], "nombre", array()), "html", null, true);
                echo "</td>
                                        ";
                // line 128
                if (($this->getAttribute($context["deposito"], "cantidad", array()) != 0)) {
                    // line 129
                    echo "                                            <td class=\"text-right\">";
                    echo twig_escape_filter($this->env, twig_number_format_filter($this->env, $this->getAttribute($context["deposito"], "cantidad", array()), 0, ",", "."), "html", null, true);
                    echo "</td>
                                        ";
                } else {
                    // line 131
                    echo "                                            <td class=\"text-right\"><span class=\"label label-default\">Sin stock</span></td>
                                        ";
                }
                // line 133
                echo "                                        ";
                $context["total"] = (($context["total"] ?? null) + $this->getAttribute($context["deposito"], "cantidad", array()));
                // line 134
                echo "                                    </tr>
                                ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['deposito'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 136
            echo "                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Total</th>
                                    <th class=\"text-right\">";
            // line 140
            echo twig_escape_filter($this->env, twig_number_format_filter($this->env, ($context["total"] ?? null), 0, ",", "."), "html", null, true);
            echo "</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>

                <div class=\"panel panel-default\">
                    <div class=\"panel-heading\">
                        Movimientos
                    </div>
                    <div class=\"panel-body\">
                        <div class=\"row\">
                            <div class=\"form-group col-md-6\">
                                ";
            // line 154
            echo $context["form"]->getlabel("movimientos-desde", "Desde el");
            echo "
                                <div class=\"input-group\">
                                    ";
            // line 156
            echo $context["form"]->gettext("movimientos-desde", twig_date_format_filter($this->env, "first day of this month", "d/m/Y"), array("class" => "form-control datepicker"));
            echo "
                                    <div class=\"input-group-addon\">
                                        <span class=\"glyphicon glyphicon-calendar\"></span>
                                    </div>
                                </div>
                            </div>
                            <div class=\"form-group col-md-6\">
                                ";
            // line 163
            echo $context["form"]->getlabel("movimientos-deposito", "Deposito");
            echo "
                                ";
            // line 164
            echo $context["form"]->getselect("movimientos-deposito", ($context["depositos"] ?? null), null, array("class" => "form-control"), "Todos los depositos");
            echo "
                            </div>
                        </div>

                        <div class=\"row\">
                            <div class=\"col-md-12 table-responsive\">
                                <div id=\"movimientos\"></div>
                            </div>
                        </div>
                    </div>
            ";
        }
        // line 175
        echo "        </div>
    </div>
";
    }

    public function getTemplateName()
    {
        return "articulo/form.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  329 => 175,  315 => 164,  311 => 163,  301 => 156,  296 => 154,  279 => 140,  273 => 136,  266 => 134,  263 => 133,  259 => 131,  253 => 129,  251 => 128,  247 => 127,  244 => 126,  239 => 125,  237 => 124,  222 => 111,  220 => 110,  204 => 97,  200 => 96,  192 => 91,  188 => 90,  176 => 81,  170 => 78,  163 => 74,  157 => 71,  150 => 67,  144 => 64,  133 => 56,  129 => 55,  120 => 49,  116 => 48,  107 => 42,  103 => 41,  94 => 35,  90 => 34,  84 => 31,  80 => 30,  72 => 24,  66 => 22,  64 => 21,  60 => 20,  50 => 14,  47 => 13,  35 => 5,  32 => 4,  28 => 2,  26 => 1,  11 => 2,);
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
            App.Articulo.Form();
        })
    </script>
{% endblock %}

{% block content %}
    <h1>{{ articulo ? 'Modificando': 'Nuevo' }} artículo</h1>

    <div class=\"alert alert-danger\" role=\"alert\" id=\"mensaje\" style=\"display:none\"></div>

    <div class=\"row\">
        <div class=\"col-md-6\">
            <form class=\"form\" id=\"form\" action=\"{{ urlFor('Articulo:save') }}\" method=\"post\" autocomplete=\"off\">
                {% if articulo %}
                    {{ form.hidden('id', articulo.id) }}
                {% endif %}

                <div class=\"panel panel-default\">
                    <div class=\"panel-body\">
                        <fieldset>
                            <div class=\"row\">
                                <div class=\"form-group required col-md-2\">
                                    {{ form.label('codigo', 'Código', { class:'control-label' }) }}
                                    {{ form.text('codigo', articulo.codigo, { class:'form-control', required:'', autofocus:'' }) }}
                                </div>
                                <div class=\"form-group required col-md-10\">
                                    {{ form.label('descripcion', 'Descripción', { class:'control-label' }) }}
                                    {{ form.text('descripcion', articulo.descripcion, { class:'form-control', required:'' }) }}
                                </div>
                            </div>

                            <div class=\"row\">
                                <div class=\"form-group required col-md-12\">
                                    {{ form.label('marca', 'Marca', { class:'control-label' }) }}
                                    {{ form.select('marca', marcas, articulo.marca_id, { class:'form-control', required:'' }) }}
                                </div>
                            </div>

                            <div class=\"row\">
                                <div class=\"form-group required col-md-12\">
                                    {{ form.label('familia', 'Familia', { class:'control-label' }) }}
                                    {{ form.select('familia', familias, articulo.familia_id, { class:'form-control', required:'' }) }}
                                </div>
                            </div>

                            <div class=\"row\">
                                <div class=\"form-group required col-md-12\">
                                    {{ form.label('proveedor', 'Proveedor', { class:'control-label' }) }}
                                    {{ form.select('proveedor', proveedores, articulo.proveedor_id, { class:'form-control', required:'' }) }}
                                </div>
                            </div>
                        </fieldset>

                        <fieldset>
                            <div class=\"row\">
                                <div class=\"form-group col-md-4\">
                                    {{ form.label('costo', 'Costo', { class:'control-label' }) }}
                                    <div class=\"input-group\">
                                        <span class=\"input-group-addon\">\$</span>
                                        {{ form.text('costo', articulo.costo, { class:'form-control calcular', placeholder:'0.00' }) }}
                                    </div>
                                </div>
                                <div class=\"form-group col-md-4\">
                                    {{ form.label('ganancia', 'Ganancia', { class:'control-label' }) }}
                                    <div class=\"input-group\">
                                        <span class=\"input-group-addon\">%</span>
                                        {{ form.text('ganancia', articulo.ganancia, { class:'form-control calcular', placeholder:'0.00' }) }}
                                    </div>
                                </div>
                                <div class=\"form-group col-md-4\">
                                    {{ form.label('precio', 'Precio de venta', { class:'control-label' }) }}
                                    <div class=\"input-group\">
                                        <span class=\"input-group-addon\">%</span>
                                        {{ form.text('precio', articulo.precio, { class:'form-control', placeholder:'0.00' }) }}
                                    </div>
                                </div>
                            </div>
                        </fieldset>

                        <fieldset>
                            <div class=\"row\">
                                <div class=\"form-group col-md-4\">
                                    {{ form.label('minimo', 'Mínimo', { class:'control-label' }) }}
                                    {{ form.text('minimo', articulo.stock_minimo, { class:'form-control', placeholder:'0.00' }) }}
                                </div>
                            </div>
                            <div class=\"row\">
                                <div class=\"form-group col-md-12\">
                                    {{ form.label('notas', 'Notas', { class:'control-label' }) }}
                                    {{ form.textarea('notas', articulo.notas, { class:'form-control', rows:'4' }) }}
                                </div>
                            </div>
                        </fieldset>
                    </div>
                    <div class=\"panel-footer\">
                        <button type=\"submit\" class=\"btn btn-success\" style=\"margin-right: 1em;\"><i class=\"glyphicon glyphicon-ok\" style=\"margin-right: 0.5em;\"></i>Guardar</button>
                        <a href=\"#\" onclick=\"history.back();\">Cancelar</a>
                    </div>
                </div>
            </form>
        </div>
        <div class=\"col-md-6\">
            {% if articulo is not null %}
                <div class=\"panel panel-default\">
                    <div class=\"panel-heading\">
                        Stock
                    </div>
                    <div class=\"panel-body\">
                        <table class=\"table table-bordered\">
                            <thead>
                                <tr>
                                    <th>Deposito</th>
                                    <th>Cantidad</th>
                                </tr>
                            </thead>
                            <tbody>
                                {% set total = 0 %}
                                {% for deposito in stock %}
                                    <tr>
                                        <td>{{ deposito.nombre }}</td>
                                        {% if deposito.cantidad != 0 %}
                                            <td class=\"text-right\">{{ deposito.cantidad|number_format(0, ',', '.') }}</td>
                                        {%  else %}
                                            <td class=\"text-right\"><span class=\"label label-default\">Sin stock</span></td>
                                        {% endif %}
                                        {% set total = total + deposito.cantidad %}
                                    </tr>
                                {% endfor %}
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Total</th>
                                    <th class=\"text-right\">{{ total|number_format(0, ',', '.') }}</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>

                <div class=\"panel panel-default\">
                    <div class=\"panel-heading\">
                        Movimientos
                    </div>
                    <div class=\"panel-body\">
                        <div class=\"row\">
                            <div class=\"form-group col-md-6\">
                                {{ form.label('movimientos-desde', 'Desde el') }}
                                <div class=\"input-group\">
                                    {{ form.text('movimientos-desde', \"first day of this month\"|date('d/m/Y'), { class:'form-control datepicker' }) }}
                                    <div class=\"input-group-addon\">
                                        <span class=\"glyphicon glyphicon-calendar\"></span>
                                    </div>
                                </div>
                            </div>
                            <div class=\"form-group col-md-6\">
                                {{ form.label('movimientos-deposito', 'Deposito') }}
                                {{ form.select('movimientos-deposito', depositos, null, { class:'form-control' }, 'Todos los depositos') }}
                            </div>
                        </div>

                        <div class=\"row\">
                            <div class=\"col-md-12 table-responsive\">
                                <div id=\"movimientos\"></div>
                            </div>
                        </div>
                    </div>
            {% endif %}
        </div>
    </div>
{% endblock %}
", "articulo/form.twig", "G:\\www\\quiosco\\app\\Views\\articulo\\form.twig");
    }
}
