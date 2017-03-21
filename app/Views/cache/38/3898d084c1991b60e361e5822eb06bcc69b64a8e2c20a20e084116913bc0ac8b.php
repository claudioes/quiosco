<?php

/* articulo/movimientos.twig */
class __TwigTemplate_98911c318f1cb683d233939b0245e8269a96ee52fcc0b8b90d980619146fd514 extends Twig_Template
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
        echo "<table class=\"table table-bordered table-hover\">
    <thead>
        <tr>
            <th class=\"text-right\">Fecha</th>
            <th>Usuario</th>
            <th>Descripción</th>
            <th>Deposito</th>
            <th class=\"text-right\">Entrada</th>
            <th class=\"text-right\">Salida</th>
            <th class=\"text-right\">Saldo</th>
        </tr>
    </thead>
    <tbody>
        ";
        // line 14
        $context["saldo"] = 0;
        // line 15
        echo "
        ";
        // line 16
        if (($context["saldoAnterior"] ?? null)) {
            // line 17
            echo "            ";
            $context["saldo"] = (($context["saldo"] ?? null) + ($context["saldoAnterior"] ?? null));
            // line 18
            echo "            <tr>
                <td colspan=\"6\" class=\"text-right\">Saldo anterior</td>
                <td class=\"text-right\">";
            // line 20
            echo twig_escape_filter($this->env, ($context["saldo"] ?? null), "html", null, true);
            echo "</td>
            </tr>
        ";
        }
        // line 23
        echo "
        ";
        // line 24
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["movimientos"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["m"]) {
            // line 25
            echo "            ";
            $context["usuario"] = $this->getAttribute($context["m"], "usuario", array());
            // line 26
            echo "            ";
            $context["deposito"] = $this->getAttribute($context["m"], "deposito", array());
            // line 27
            echo "
            ";
            // line 28
            if (($this->getAttribute($context["m"], "tipo", array()) == "E")) {
                // line 29
                echo "                ";
                $context["saldo"] = (($context["saldo"] ?? null) + $this->getAttribute($context["m"], "cantidad", array()));
                // line 30
                echo "            ";
            } else {
                // line 31
                echo "                ";
                $context["saldo"] = (($context["saldo"] ?? null) - $this->getAttribute($context["m"], "cantidad", array()));
                // line 32
                echo "            ";
            }
            // line 33
            echo "
            <tr>
                <td class=\"text-right\">";
            // line 35
            echo twig_escape_filter($this->env, twig_date_format_filter($this->env, $this->getAttribute($context["m"], "fecha", array()), "d/m/Y"), "html", null, true);
            echo "</td>
                <td>";
            // line 36
            echo twig_escape_filter($this->env, $this->getAttribute(($context["usuario"] ?? null), "nombre", array()), "html", null, true);
            echo " ";
            echo twig_escape_filter($this->env, $this->getAttribute(($context["usuario"] ?? null), "apellido", array()), "html", null, true);
            echo "</td>
                <td>";
            // line 37
            echo twig_escape_filter($this->env, $this->getAttribute($context["m"], "descripcion", array()), "html", null, true);
            echo "</td>
                <td>";
            // line 38
            echo twig_escape_filter($this->env, $this->getAttribute(($context["deposito"] ?? null), "nombre", array()), "html", null, true);
            echo "</td>
                <td class=\"text-right\">";
            // line 39
            echo twig_escape_filter($this->env, ((($this->getAttribute($context["m"], "tipo", array()) == "E")) ? ($this->getAttribute($context["m"], "cantidad", array())) : ("")), "html", null, true);
            echo "</td>
                <td class=\"text-right\">";
            // line 40
            echo twig_escape_filter($this->env, ((($this->getAttribute($context["m"], "tipo", array()) == "S")) ? ($this->getAttribute($context["m"], "cantidad", array())) : ("")), "html", null, true);
            echo "</td>
                <td class=\"text-right\">";
            // line 41
            echo twig_escape_filter($this->env, ($context["saldo"] ?? null), "html", null, true);
            echo "</td>
            </tr>
        ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['m'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 44
        echo "        <tr>
            <td colspan=\"6\" class=\"text-right\">Total</td>
            <td class=\"text-right\">";
        // line 46
        echo twig_escape_filter($this->env, ($context["saldo"] ?? null), "html", null, true);
        echo "</td>
        </tr>
    </tbody>
</table>
";
    }

    public function getTemplateName()
    {
        return "articulo/movimientos.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  127 => 46,  123 => 44,  114 => 41,  110 => 40,  106 => 39,  102 => 38,  98 => 37,  92 => 36,  88 => 35,  84 => 33,  81 => 32,  78 => 31,  75 => 30,  72 => 29,  70 => 28,  67 => 27,  64 => 26,  61 => 25,  57 => 24,  54 => 23,  48 => 20,  44 => 18,  41 => 17,  39 => 16,  36 => 15,  34 => 14,  19 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("<table class=\"table table-bordered table-hover\">
    <thead>
        <tr>
            <th class=\"text-right\">Fecha</th>
            <th>Usuario</th>
            <th>Descripción</th>
            <th>Deposito</th>
            <th class=\"text-right\">Entrada</th>
            <th class=\"text-right\">Salida</th>
            <th class=\"text-right\">Saldo</th>
        </tr>
    </thead>
    <tbody>
        {% set saldo = 0 %}

        {% if saldoAnterior %}
            {% set saldo = saldo + saldoAnterior %}
            <tr>
                <td colspan=\"6\" class=\"text-right\">Saldo anterior</td>
                <td class=\"text-right\">{{ saldo }}</td>
            </tr>
        {% endif %}

        {% for m in movimientos %}
            {% set usuario = m.usuario %}
            {% set deposito = m.deposito %}

            {% if m.tipo == 'E' %}
                {% set saldo = saldo + m.cantidad %}
            {% else %}
                {% set saldo = saldo - m.cantidad %}
            {% endif %}

            <tr>
                <td class=\"text-right\">{{ m.fecha|date('d/m/Y') }}</td>
                <td>{{ usuario.nombre }} {{ usuario.apellido }}</td>
                <td>{{ m.descripcion }}</td>
                <td>{{ deposito.nombre }}</td>
                <td class=\"text-right\">{{ m.tipo == 'E' ? m.cantidad : '' }}</td>
                <td class=\"text-right\">{{ m.tipo == 'S' ? m.cantidad : '' }}</td>
                <td class=\"text-right\">{{ saldo }}</td>
            </tr>
        {% endfor %}
        <tr>
            <td colspan=\"6\" class=\"text-right\">Total</td>
            <td class=\"text-right\">{{ saldo }}</td>
        </tr>
    </tbody>
</table>
", "articulo/movimientos.twig", "G:\\www\\quiosco\\app\\Views\\articulo\\movimientos.twig");
    }
}
