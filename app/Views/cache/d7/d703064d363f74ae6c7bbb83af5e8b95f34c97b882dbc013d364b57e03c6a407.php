<?php

/* pedido/print.twig */
class __TwigTemplate_4fe2c867c9cccd9b43a9044e0e5fe16ff765dbf776de03c7c4daa5b81055fbff extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        $this->parent = $this->loadTemplate("/pedido/print-base.twig", "pedido/print.twig", 1);
        $this->blocks = array(
            'content' => array($this, 'block_content'),
        );
    }

    protected function doGetParent(array $context)
    {
        return "/pedido/print-base.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    public function block_content($context, array $blocks = array())
    {
        // line 4
        echo "    <table class=\"cabecera\">
        <tr>
            <td colspan=\"4\" class=\"text-center\"><h2>PEDIDO Nº ";
        // line 6
        echo twig_escape_filter($this->env, $this->getAttribute(($context["pedido"] ?? null), "id", array()), "html", null, true);
        echo "<h2></td>
        </tr>
        <tr>
            <td><strong>Cliente:</string></td>
            <td class=\"w100\">";
        // line 10
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute(($context["pedido"] ?? null), "cliente", array()), "nombre", array()), "html", null, true);
        echo "</td>
            <td class=\"text-right\"><strong>Fecha:</strong></td>
            <td class=\"text-right\">";
        // line 12
        echo twig_escape_filter($this->env, twig_date_format_filter($this->env, $this->getAttribute(($context["presupuesto"] ?? null), "fecha", array()), "d/m/Y"), "html", null, true);
        echo "</td>
        </tr>
    </table>
    <table class=\"detalle\">
        <thead>
            <tr>
                <th>Código</th>
                <th class=\"w100\">Descripción</th>
                <th>Cantidad</th>
            </tr>
        </thead>
        <tbody>
            ";
        // line 24
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["detalle"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["linea"]) {
            // line 25
            echo "                <tr>
                    ";
            // line 26
            $context["articulo"] = $this->getAttribute($context["linea"], "articulo", array());
            // line 27
            echo "                    <td class=\"text-right\">";
            echo twig_escape_filter($this->env, $this->getAttribute(($context["articulo"] ?? null), "codigo", array()), "html", null, true);
            echo "</td>
                    <td>";
            // line 28
            echo twig_escape_filter($this->env, $this->getAttribute(($context["articulo"] ?? null), "descripcion", array()), "html", null, true);
            echo "</td>
                    <td class=\"text-right\">";
            // line 29
            echo twig_escape_filter($this->env, $this->getAttribute($context["linea"], "cantidad", array()), "html", null, true);
            echo "</td>
                </tr>
            ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['linea'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 32
        echo "        </tbody>
    </table>
";
    }

    public function getTemplateName()
    {
        return "pedido/print.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  89 => 32,  80 => 29,  76 => 28,  71 => 27,  69 => 26,  66 => 25,  62 => 24,  47 => 12,  42 => 10,  35 => 6,  31 => 4,  28 => 3,  11 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("{% extends \"/pedido/print-base.twig\" %}

{% block content %}
    <table class=\"cabecera\">
        <tr>
            <td colspan=\"4\" class=\"text-center\"><h2>PEDIDO Nº {{ pedido.id }}<h2></td>
        </tr>
        <tr>
            <td><strong>Cliente:</string></td>
            <td class=\"w100\">{{ pedido.cliente.nombre }}</td>
            <td class=\"text-right\"><strong>Fecha:</strong></td>
            <td class=\"text-right\">{{ presupuesto.fecha|date(\"d/m/Y\") }}</td>
        </tr>
    </table>
    <table class=\"detalle\">
        <thead>
            <tr>
                <th>Código</th>
                <th class=\"w100\">Descripción</th>
                <th>Cantidad</th>
            </tr>
        </thead>
        <tbody>
            {% for linea in detalle %}
                <tr>
                    {% set articulo = linea.articulo %}
                    <td class=\"text-right\">{{ articulo.codigo }}</td>
                    <td>{{ articulo.descripcion }}</td>
                    <td class=\"text-right\">{{ linea.cantidad }}</td>
                </tr>
            {% endfor %}
        </tbody>
    </table>
{% endblock %}
", "pedido/print.twig", "G:\\www\\quiosco\\app\\Views\\pedido\\print.twig");
    }
}
