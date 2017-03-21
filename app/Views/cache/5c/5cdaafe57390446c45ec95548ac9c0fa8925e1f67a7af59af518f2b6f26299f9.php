<?php

/* cliente/print_cc.twig */
class __TwigTemplate_3b12a7116b0f3aced106a0c06f4cca1c14aaf801a5e3f11e554c8557282e7f88 extends Twig_Template
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
        echo "<!DOCTYPE html>
<html lang=\"en\">
    <head>
        <meta charset=\"UTF-8\">
        <title>Cuenta corriente de ";
        // line 5
        echo twig_escape_filter($this->env, $this->getAttribute(($context["cliente"] ?? null), "nombre", array()), "html", null, true);
        echo "</title>
        <style>
            body {
                margin: 0;
                padding: 0;
                font: normal 11px tahoma, helvetica, arial, sans-serif;
            }
            table, tr, td, th, tbody, thead, tfoot {
                page-break-inside: avoid !important;
            }
            table {
            \tborder-collapse: collapse;
            \tborder-spacing: 0;
            }
            table th, td {
                padding: 4px;
            }
            table thead th {
                background-color: rgb(200, 200, 200);
                border: solid 2px rgb(100, 100, 100);
                padding: 5px;
            }
            table tbody td {
                border: solid 1px rgb(200, 200, 200);
            }
            table td.debe {
                color: #006600;
            }
            table td.haber {
                color: #CC0000;
            }
            table tr.totales {
                font-weight: bold;
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
            .nowrap {
                white-space: nowrap;
            }
        </style>
    </head>
    <body onload=\"window.print()\">
        <div class=\"w100\">
            <div class=\"text-center\">
                <h2>CUENTA CORRIENTE DE ";
        // line 56
        echo twig_escape_filter($this->env, twig_upper_filter($this->env, $this->getAttribute(($context["cliente"] ?? null), "nombre", array())), "html", null, true);
        echo "</h2>
                <p>
                    ";
        // line 58
        if (($context["desde"] ?? null)) {
            // line 59
            echo "                        DESDE EL ";
            echo twig_escape_filter($this->env, twig_date_format_filter($this->env, ($context["desde"] ?? null), "d/m/Y"), "html", null, true);
            echo "
                    ";
        }
        // line 61
        echo "
                    ";
        // line 62
        if (($context["hasta"] ?? null)) {
            // line 63
            echo "                        HASTA EL ";
            echo twig_escape_filter($this->env, twig_date_format_filter($this->env, ($context["hasta"] ?? null), "d/m/Y"), "html", null, true);
            echo "
                    ";
        }
        // line 65
        echo "                </p>
            </div>
            <table>
                <thead>
                    <tr>
                        <th>Fecha</th>
                        <th class=\"w100\">Concepto</th>
                        <th>Debe</th>
                        <th>Haber</th>
                        <th>Saldo</th>
                    </tr>
                </thead>
                <tbody>
                    ";
        // line 78
        list($context["totalDebe"], $context["totalHaber"], $context["totalSaldo"]) =         array(0, 0, 0);
        // line 79
        echo "                    ";
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["resumen"] ?? null));
        $context['_iterated'] = false;
        foreach ($context['_seq'] as $context["_key"] => $context["ln"]) {
            // line 80
            echo "                        <tr>
                            <td class=\"text-right\">";
            // line 81
            echo twig_escape_filter($this->env, $this->getAttribute($context["ln"], "fecha", array()), "html", null, true);
            echo "</td>
                            <td>
                                ";
            // line 83
            echo twig_escape_filter($this->env, $this->getAttribute($context["ln"], "concepto", array()), "html", null, true);
            echo "
                                ";
            // line 84
            if ($this->getAttribute($context["ln"], "presupuesto", array())) {
                // line 85
                echo "                                    (de ";
                echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute($context["ln"], "presupuesto", array()), "cliente", array()), "nombre", array()), "html", null, true);
                echo ")
                                ";
            }
            // line 87
            echo "                            </td>
                            <td class=\"text-right debe nowrap\">
                                ";
            // line 89
            if (($this->getAttribute($context["ln"], "debe", array()) > 0)) {
                // line 90
                echo "                                    \$ ";
                echo twig_escape_filter($this->env, twig_number_format_filter($this->env, $this->getAttribute($context["ln"], "debe", array()), 2, ",", "."), "html", null, true);
                echo "
                                ";
            }
            // line 92
            echo "                            </td>
                            <td class=\"text-right haber nowrap\">
                                ";
            // line 94
            if (($this->getAttribute($context["ln"], "haber", array()) > 0)) {
                // line 95
                echo "                                    \$ ";
                echo twig_escape_filter($this->env, twig_number_format_filter($this->env, $this->getAttribute($context["ln"], "haber", array()), 2, ",", "."), "html", null, true);
                echo "
                                ";
            }
            // line 97
            echo "                            <td class=\"text-right nowrap\">
                                \$ ";
            // line 98
            echo twig_escape_filter($this->env, twig_number_format_filter($this->env, $this->getAttribute($context["ln"], "saldo", array()), 2, ",", "."), "html", null, true);
            echo "
                            </td>
                        </tr>
                    ";
            $context['_iterated'] = true;
        }
        if (!$context['_iterated']) {
            // line 102
            echo "                        <tr>
                            <td colspan=\"5\" class=\"text-center\">Sin movimientos</td>
                        </tr>
                    ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['ln'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 106
        echo "                </tbody>
            </table>
        </div>
    </body>
</html>
";
    }

    public function getTemplateName()
    {
        return "cliente/print_cc.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  191 => 106,  182 => 102,  173 => 98,  170 => 97,  164 => 95,  162 => 94,  158 => 92,  152 => 90,  150 => 89,  146 => 87,  140 => 85,  138 => 84,  134 => 83,  129 => 81,  126 => 80,  120 => 79,  118 => 78,  103 => 65,  97 => 63,  95 => 62,  92 => 61,  86 => 59,  84 => 58,  79 => 56,  25 => 5,  19 => 1,);
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
        <title>Cuenta corriente de {{ cliente.nombre }}</title>
        <style>
            body {
                margin: 0;
                padding: 0;
                font: normal 11px tahoma, helvetica, arial, sans-serif;
            }
            table, tr, td, th, tbody, thead, tfoot {
                page-break-inside: avoid !important;
            }
            table {
            \tborder-collapse: collapse;
            \tborder-spacing: 0;
            }
            table th, td {
                padding: 4px;
            }
            table thead th {
                background-color: rgb(200, 200, 200);
                border: solid 2px rgb(100, 100, 100);
                padding: 5px;
            }
            table tbody td {
                border: solid 1px rgb(200, 200, 200);
            }
            table td.debe {
                color: #006600;
            }
            table td.haber {
                color: #CC0000;
            }
            table tr.totales {
                font-weight: bold;
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
            .nowrap {
                white-space: nowrap;
            }
        </style>
    </head>
    <body onload=\"window.print()\">
        <div class=\"w100\">
            <div class=\"text-center\">
                <h2>CUENTA CORRIENTE DE {{ cliente.nombre|upper }}</h2>
                <p>
                    {% if desde %}
                        DESDE EL {{ desde|date(\"d/m/Y\") }}
                    {% endif %}

                    {% if hasta %}
                        HASTA EL {{ hasta|date(\"d/m/Y\") }}
                    {% endif %}
                </p>
            </div>
            <table>
                <thead>
                    <tr>
                        <th>Fecha</th>
                        <th class=\"w100\">Concepto</th>
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
                            <td>
                                {{ ln.concepto }}
                                {% if ln.presupuesto %}
                                    (de {{ ln.presupuesto.cliente.nombre }})
                                {% endif %}
                            </td>
                            <td class=\"text-right debe nowrap\">
                                {% if ln.debe > 0 %}
                                    \$ {{ ln.debe|number_format(2, ',', '.') }}
                                {% endif %}
                            </td>
                            <td class=\"text-right haber nowrap\">
                                {% if ln.haber > 0 %}
                                    \$ {{ ln.haber|number_format(2, ',', '.') }}
                                {% endif %}
                            <td class=\"text-right nowrap\">
                                \$ {{ ln.saldo|number_format(2, ',', '.') }}
                            </td>
                        </tr>
                    {% else %}
                        <tr>
                            <td colspan=\"5\" class=\"text-center\">Sin movimientos</td>
                        </tr>
                    {% endfor %}
                </tbody>
            </table>
        </div>
    </body>
</html>
", "cliente/print_cc.twig", "G:\\www\\quiosco\\app\\Views\\cliente\\print_cc.twig");
    }
}
