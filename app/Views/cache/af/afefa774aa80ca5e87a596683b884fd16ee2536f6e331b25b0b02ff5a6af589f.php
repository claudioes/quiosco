<?php

/* cliente/_table_cc.twig */
class __TwigTemplate_8e36a7daf9f10518974ebec7dbf3557891c80341f788c9748b551ce62637856c extends Twig_Template
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
        echo "<div class=\"table-responsive\">
    <table class=\"table table-bordered table-hover\">
        <thead>
            <tr>
                <th>Fecha</th>
                <th style=\"width: 100%\">Concepto</th>
                <th>Debe</th>
                <th>Haber</th>
                <th>Saldo</th>
            </tr>
        </thead>
        <tbody>
            ";
        // line 13
        list($context["totalDebe"], $context["totalHaber"], $context["totalSaldo"]) =         array(0, 0, 0);
        // line 14
        echo "            ";
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["resumen"] ?? null));
        $context['_iterated'] = false;
        foreach ($context['_seq'] as $context["_key"] => $context["ln"]) {
            // line 15
            echo "                <tr>
                    <td class=\"text-right\">";
            // line 16
            echo twig_escape_filter($this->env, $this->getAttribute($context["ln"], "fecha", array()), "html", null, true);
            echo "</td>
                    ";
            // line 17
            if ($this->getAttribute($context["ln"], "presupuesto", array())) {
                // line 18
                echo "                        <td><a href=\"";
                echo twig_escape_filter($this->env, $this->env->getExtension('Slim\Views\TwigExtension')->urlFor("Presupuesto:printPage", array("id" => $this->getAttribute($this->getAttribute($context["ln"], "presupuesto", array()), "id", array()))), "html", null, true);
                echo "\" target=\"_blank\">";
                echo twig_escape_filter($this->env, $this->getAttribute($context["ln"], "concepto", array()), "html", null, true);
                echo "</a></td>
                    ";
            } elseif ($this->getAttribute(            // line 19
$context["ln"], "recibo", array())) {
                // line 20
                echo "                        <td><a href=\"#\" data-url=\"";
                echo twig_escape_filter($this->env, $this->env->getExtension('Slim\Views\TwigExtension')->urlFor("Caja:viewRecibo", array("id" => $this->getAttribute($this->getAttribute($context["ln"], "recibo", array()), "id", array()))), "html", null, true);
                echo "\" class=\"recibo\">";
                echo twig_escape_filter($this->env, $this->getAttribute($context["ln"], "concepto", array()), "html", null, true);
                echo "</a></td>
                    ";
            } else {
                // line 22
                echo "                        <td>";
                echo twig_escape_filter($this->env, $this->getAttribute($context["ln"], "concepto", array()), "html", null, true);
                echo "</td>
                    ";
            }
            // line 24
            echo "                    <td class=\"text-right nowrap\" style=\"color: #006600\">
                        ";
            // line 25
            if ($this->getAttribute($context["ln"], "debe", array())) {
                // line 26
                echo "                            \$ ";
                echo twig_escape_filter($this->env, twig_number_format_filter($this->env, $this->getAttribute($context["ln"], "debe", array()), 2, ",", "."), "html", null, true);
                echo "
                        ";
            }
            // line 28
            echo "                    </td>
                    <td class=\"text-right nowrap\" style=\"color: #CC0000\">
                        ";
            // line 30
            if ($this->getAttribute($context["ln"], "haber", array())) {
                // line 31
                echo "                            \$ ";
                echo twig_escape_filter($this->env, twig_number_format_filter($this->env, $this->getAttribute($context["ln"], "haber", array()), 2, ",", "."), "html", null, true);
                echo "
                        ";
            }
            // line 33
            echo "                    </td>
                    <td class=\"text-right nowrap\">
                        \$ ";
            // line 35
            echo twig_escape_filter($this->env, twig_number_format_filter($this->env, $this->getAttribute($context["ln"], "saldo", array()), 2, ",", "."), "html", null, true);
            echo "
                    </td>
                </tr>
            ";
            $context['_iterated'] = true;
        }
        if (!$context['_iterated']) {
            // line 39
            echo "                <tr>
                    <td colspan=\"6\" class=\"text-center\">Sin movimientos</td>
                </tr>
            ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['ln'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 43
        echo "        </tbody>
    </table>
</div>
";
    }

    public function getTemplateName()
    {
        return "cliente/_table_cc.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  118 => 43,  109 => 39,  100 => 35,  96 => 33,  90 => 31,  88 => 30,  84 => 28,  78 => 26,  76 => 25,  73 => 24,  67 => 22,  59 => 20,  57 => 19,  50 => 18,  48 => 17,  44 => 16,  41 => 15,  35 => 14,  33 => 13,  19 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("<div class=\"table-responsive\">
    <table class=\"table table-bordered table-hover\">
        <thead>
            <tr>
                <th>Fecha</th>
                <th style=\"width: 100%\">Concepto</th>
                <th>Debe</th>
                <th>Haber</th>
                <th>Saldo</th>
            </tr>
        </thead>
        <tbody>
            {% set totalDebe, totalHaber, totalSaldo = 0, 0, 0 %}
            {% for ln in resumen %}
                <tr>
                    <td class=\"text-right\">{{ ln.fecha }}</td>
                    {% if ln.presupuesto %}
                        <td><a href=\"{{ urlFor('Presupuesto:printPage', { id: ln.presupuesto.id }) }}\" target=\"_blank\">{{ ln.concepto }}</a></td>
                    {% elseif ln.recibo %}
                        <td><a href=\"#\" data-url=\"{{ urlFor('Caja:viewRecibo', { id: ln.recibo.id }) }}\" class=\"recibo\">{{ ln.concepto }}</a></td>
                    {% else %}
                        <td>{{ ln.concepto }}</td>
                    {% endif %}
                    <td class=\"text-right nowrap\" style=\"color: #006600\">
                        {% if ln.debe %}
                            \$ {{ ln.debe|number_format(2, ',', '.') }}
                        {% endif %}
                    </td>
                    <td class=\"text-right nowrap\" style=\"color: #CC0000\">
                        {% if ln.haber %}
                            \$ {{ ln.haber|number_format(2, ',', '.') }}
                        {% endif %}
                    </td>
                    <td class=\"text-right nowrap\">
                        \$ {{ ln.saldo|number_format(2, ',', '.') }}
                    </td>
                </tr>
            {% else %}
                <tr>
                    <td colspan=\"6\" class=\"text-center\">Sin movimientos</td>
                </tr>
            {% endfor %}
        </tbody>
    </table>
</div>
", "cliente/_table_cc.twig", "G:\\www\\quiosco\\app\\Views\\cliente\\_table_cc.twig");
    }
}
