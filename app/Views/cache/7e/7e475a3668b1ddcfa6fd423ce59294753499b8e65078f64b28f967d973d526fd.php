<?php

/* cliente/_tab_detalle.twig */
class __TwigTemplate_4cf84e632c8983b9b83377522368f9008bdb26a70fbf39cf4676a062876970f8 extends Twig_Template
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
    <div class=\"form-group col-sm-2 required\">
        ";
        // line 3
        echo twig_escape_filter($this->env, $this->getAttribute(($context["form"] ?? null), "label", array(0 => "codigo", 1 => "Código", 2 => array("class" => "control-label")), "method"), "html", null, true);
        echo "
        ";
        // line 4
        echo twig_escape_filter($this->env, $this->getAttribute(($context["form"] ?? null), "text", array(0 => "codigo", 1 => $this->getAttribute(($context["cliente"] ?? null), "codigo", array()), 2 => array("class" => "form-control", "required" => "", "autofocus" => "")), "method"), "html", null, true);
        echo "
    </div>
    <div class=\"form-group col-sm-10 required\">
        ";
        // line 7
        echo twig_escape_filter($this->env, $this->getAttribute(($context["form"] ?? null), "label", array(0 => "nombre", 1 => "Nombre", 2 => array("class" => "control-label")), "method"), "html", null, true);
        echo "
        ";
        // line 8
        echo twig_escape_filter($this->env, $this->getAttribute(($context["form"] ?? null), "text", array(0 => "nombre", 1 => $this->getAttribute(($context["cliente"] ?? null), "nombre", array()), 2 => array("class" => "form-control", "required" => "")), "method"), "html", null, true);
        echo "
    </div>
</div>

<div class=\"row\">
    <div class=\"form-group col-sm-8\">
        ";
        // line 14
        echo twig_escape_filter($this->env, $this->getAttribute(($context["form"] ?? null), "label", array(0 => "razon", 1 => "Razón social", 2 => array("class" => "control-label")), "method"), "html", null, true);
        echo "
        ";
        // line 15
        echo twig_escape_filter($this->env, $this->getAttribute(($context["form"] ?? null), "text", array(0 => "razon", 1 => $this->getAttribute(($context["cliente"] ?? null), "razon", array()), 2 => array("class" => "form-control")), "method"), "html", null, true);
        echo "
    </div>
    <div class=\"form-group col-sm-4\">
        ";
        // line 18
        echo twig_escape_filter($this->env, $this->getAttribute(($context["form"] ?? null), "label", array(0 => "cuit", 1 => "CUIT", 2 => array("class" => "control-label")), "method"), "html", null, true);
        echo "
        <div class=\"input-group\">
            ";
        // line 20
        echo twig_escape_filter($this->env, $this->getAttribute(($context["form"] ?? null), "text", array(0 => "cuit", 1 => $this->getAttribute(($context["cliente"] ?? null), "cuit", array()), 2 => array("class" => "form-control")), "method"), "html", null, true);
        echo "
            <span class=\"input-group-btn\">
                ";
        // line 22
        echo twig_escape_filter($this->env, $this->getAttribute(($context["form"] ?? null), "button", array(0 => "buscar-cuit", 1 => "<i class=\"glyphicon glyphicon-refresh\"></i>", 2 => array("class" => "btn btn-default", "title" => "Buscar y completar datos del CUIT")), "method"), "html", null, true);
        echo "
            </span>
        </div>
    </div>
</div>

<div class=\"row\">
    <div class=\"form-group col-sm-6\">
        ";
        // line 30
        echo twig_escape_filter($this->env, $this->getAttribute(($context["form"] ?? null), "label", array(0 => "telefono", 1 => "Teléfono", 2 => array("class" => "control-label")), "method"), "html", null, true);
        echo "
        ";
        // line 31
        echo twig_escape_filter($this->env, $this->getAttribute(($context["form"] ?? null), "text", array(0 => "telefono", 1 => $this->getAttribute(($context["cliente"] ?? null), "telefono", array()), 2 => array("class" => "form-control")), "method"), "html", null, true);
        echo "
    </div>
    <div class=\"form-group col-sm-6\">
        ";
        // line 34
        echo twig_escape_filter($this->env, $this->getAttribute(($context["form"] ?? null), "label", array(0 => "email", 1 => "E-Mail", 2 => array("class" => "control-label")), "method"), "html", null, true);
        echo "
        ";
        // line 35
        echo twig_escape_filter($this->env, $this->getAttribute(($context["form"] ?? null), "text", array(0 => "email", 1 => $this->getAttribute(($context["cliente"] ?? null), "email", array()), 2 => array("class" => "form-control")), "method"), "html", null, true);
        echo "
    </div>
</div>

<div class=\"panel panel-default\">
    <div class=\"panel-heading\">Días de visita</div>
    <div class=\"panel-body\">
        <div class=\"row\">
            <div class=\"form-group col-sm-12\">
                ";
        // line 44
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["dias"] ?? null));
        foreach ($context['_seq'] as $context["key"] => $context["dia"]) {
            // line 45
            echo "                    ";
            echo twig_escape_filter($this->env, $this->getAttribute(($context["form"] ?? null), "checkbox", array(0 => $context["dia"], 1 => ($this->getAttribute(($context["cliente"] ?? null), "dias_visita", array()) & $context["key"]), 2 => array("name" => "dias_visita[]", "value" => $context["key"])), "method"), "html", null, true);
            echo "
                ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['key'], $context['dia'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 47
        echo "            </div>
        </div>
    </div>
</div>

<div class=\"panel panel-default\">
    <div class=\"panel-heading\">Dirección de facturación</div>
    <div class=\"panel-body\">
        <div class=\"row\">
            <div class=\"form-group col-sm-12\">
                ";
        // line 57
        echo twig_escape_filter($this->env, $this->getAttribute(($context["form"] ?? null), "label", array(0 => "domicilio", 1 => "Domicilio", 2 => array("class" => "control-label")), "method"), "html", null, true);
        echo "
                ";
        // line 58
        echo twig_escape_filter($this->env, $this->getAttribute(($context["form"] ?? null), "text", array(0 => "domicilio", 1 => $this->getAttribute(($context["cliente"] ?? null), "domicilio", array()), 2 => array("class" => "form-control")), "method"), "html", null, true);
        echo "
            </div>
        </div>

        <div class=\"row\">
            <div class=\"form-group col-sm-8\">
                ";
        // line 64
        echo twig_escape_filter($this->env, $this->getAttribute(($context["form"] ?? null), "label", array(0 => "localidad", 1 => "Localidad", 2 => array("class" => "control-label")), "method"), "html", null, true);
        echo "
                ";
        // line 65
        echo twig_escape_filter($this->env, $this->getAttribute(($context["form"] ?? null), "text", array(0 => "localidad", 1 => $this->getAttribute(($context["cliente"] ?? null), "localidad", array()), 2 => array("class" => "form-control")), "method"), "html", null, true);
        echo "
            </div>
            <div class=\"form-group col-sm-4\">
                ";
        // line 68
        echo twig_escape_filter($this->env, $this->getAttribute(($context["form"] ?? null), "label", array(0 => "cp", 1 => "Cód. Postal", 2 => array("class" => "control-label")), "method"), "html", null, true);
        echo "
                ";
        // line 69
        echo twig_escape_filter($this->env, $this->getAttribute(($context["form"] ?? null), "text", array(0 => "cp", 1 => $this->getAttribute(($context["cliente"] ?? null), "cp", array()), 2 => array("class" => "form-control")), "method"), "html", null, true);
        echo "
            </div>
        </div>
    </div>
</div>

<div class=\"panel panel-default\">
    <div class=\"panel-heading\">Dirección de entrega</div>
    <div class=\"panel-body\">
        <div class=\"row\">
            <div class=\"form-group col-sm-12\">
                ";
        // line 80
        echo twig_escape_filter($this->env, $this->getAttribute(($context["form"] ?? null), "label", array(0 => "domicilio-entrega", 1 => "Domicilio", 2 => array("class" => "control-label")), "method"), "html", null, true);
        echo "
                ";
        // line 81
        echo twig_escape_filter($this->env, $this->getAttribute(($context["form"] ?? null), "text", array(0 => "domicilio-entrega", 1 => $this->getAttribute(($context["cliente"] ?? null), "domicilio_entrega", array()), 2 => array("class" => "form-control")), "method"), "html", null, true);
        echo "
            </div>
        </div>

        <div class=\"row\">
            <div class=\"form-group col-sm-8\">
                ";
        // line 87
        echo twig_escape_filter($this->env, $this->getAttribute(($context["form"] ?? null), "label", array(0 => "localidad-entrega", 1 => "Localidad", 2 => array("class" => "control-label")), "method"), "html", null, true);
        echo "
                ";
        // line 88
        echo twig_escape_filter($this->env, $this->getAttribute(($context["form"] ?? null), "text", array(0 => "localidad-entrega", 1 => $this->getAttribute(($context["cliente"] ?? null), "localidad_entrega", array()), 2 => array("class" => "form-control")), "method"), "html", null, true);
        echo "
            </div>
            <div class=\"form-group col-sm-4\">
                ";
        // line 91
        echo twig_escape_filter($this->env, $this->getAttribute(($context["form"] ?? null), "label", array(0 => "cp-entrega", 1 => "Código postal", 2 => array("class" => "control-label")), "method"), "html", null, true);
        echo "
                ";
        // line 92
        echo twig_escape_filter($this->env, $this->getAttribute(($context["form"] ?? null), "text", array(0 => "cp-entrega", 1 => $this->getAttribute(($context["cliente"] ?? null), "cp_entrega", array()), 2 => array("class" => "form-control")), "method"), "html", null, true);
        echo "
            </div>
        </div>
    </div>
</div>

<div class=\"row\">
    <div class=\"form-group required col-sm-6\">
        ";
        // line 100
        echo twig_escape_filter($this->env, $this->getAttribute(($context["form"] ?? null), "label", array(0 => "grupo", 1 => "Grupo", 2 => array("class" => "control-label")), "method"), "html", null, true);
        echo "
        ";
        // line 101
        echo twig_escape_filter($this->env, $this->getAttribute(($context["form"] ?? null), "select", array(0 => "grupo", 1 => ($context["grupos"] ?? null), 2 => $this->getAttribute(($context["cliente"] ?? null), "grupo_id", array()), 3 => array("class" => "form-control", "required" => "")), "method"), "html", null, true);
        echo "
    </div>
    <div class=\"form-group required col-sm-6\">
        ";
        // line 104
        echo twig_escape_filter($this->env, $this->getAttribute(($context["form"] ?? null), "label", array(0 => "forma-pago", 1 => "Forma de pago", 2 => array("class" => "control-label")), "method"), "html", null, true);
        echo "
        ";
        // line 105
        echo twig_escape_filter($this->env, $this->getAttribute(($context["form"] ?? null), "select", array(0 => "forma-pago", 1 => ($context["formas_pago"] ?? null), 2 => $this->getAttribute(($context["cliente"] ?? null), "forma_pago_id", array()), 3 => array("class" => "form-control", "required" => "")), "method"), "html", null, true);
        echo "
    </div>
</div>

<div class=\"row\">
    <div class=\"form-group col-sm-12\">
        ";
        // line 111
        echo twig_escape_filter($this->env, $this->getAttribute(($context["form"] ?? null), "label", array(0 => "notas", 1 => "Notas", 2 => array("class" => "control-label")), "method"), "html", null, true);
        echo "
        ";
        // line 112
        echo twig_escape_filter($this->env, $this->getAttribute(($context["form"] ?? null), "textarea", array(0 => "notas", 1 => $this->getAttribute(($context["cliente"] ?? null), "notas", array()), 2 => array("class" => "form-control", "rows" => "4")), "method"), "html", null, true);
        echo "
    </div>
</div>

<div class=\"row\">
    <div class=\"form-group col-sm-12\">
        ";
        // line 118
        echo twig_escape_filter($this->env, $this->getAttribute(($context["form"] ?? null), "label", array(0 => "adv", 1 => "Advertencias", 2 => array("class" => "control-label")), "method"), "html", null, true);
        echo "
        ";
        // line 119
        echo twig_escape_filter($this->env, $this->getAttribute(($context["form"] ?? null), "textarea", array(0 => "adv", 1 => $this->getAttribute(($context["cliente"] ?? null), "adv", array()), 2 => array("class" => "form-control bg-adv", "rows" => "4")), "method"), "html", null, true);
        echo "
    </div>
</div>
";
    }

    public function getTemplateName()
    {
        return "cliente/_tab_detalle.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  247 => 119,  243 => 118,  234 => 112,  230 => 111,  221 => 105,  217 => 104,  211 => 101,  207 => 100,  196 => 92,  192 => 91,  186 => 88,  182 => 87,  173 => 81,  169 => 80,  155 => 69,  151 => 68,  145 => 65,  141 => 64,  132 => 58,  128 => 57,  116 => 47,  107 => 45,  103 => 44,  91 => 35,  87 => 34,  81 => 31,  77 => 30,  66 => 22,  61 => 20,  56 => 18,  50 => 15,  46 => 14,  37 => 8,  33 => 7,  27 => 4,  23 => 3,  19 => 1,);
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
    <div class=\"form-group col-sm-2 required\">
        {{ form.label('codigo', 'Código', { class:'control-label' }) }}
        {{ form.text('codigo', cliente.codigo, { class:'form-control', required:'', autofocus:'' }) }}
    </div>
    <div class=\"form-group col-sm-10 required\">
        {{ form.label('nombre', 'Nombre', { class:'control-label' }) }}
        {{ form.text('nombre', cliente.nombre, { class:'form-control', required:'' }) }}
    </div>
</div>

<div class=\"row\">
    <div class=\"form-group col-sm-8\">
        {{ form.label('razon', 'Razón social', { class:'control-label' }) }}
        {{ form.text('razon', cliente.razon, { class:'form-control' }) }}
    </div>
    <div class=\"form-group col-sm-4\">
        {{ form.label('cuit', 'CUIT', { class: 'control-label' }) }}
        <div class=\"input-group\">
            {{ form.text('cuit', cliente.cuit, { class: 'form-control' }) }}
            <span class=\"input-group-btn\">
                {{ form.button('buscar-cuit', '<i class=\"glyphicon glyphicon-refresh\"></i>', { class: 'btn btn-default', title: 'Buscar y completar datos del CUIT' }) }}
            </span>
        </div>
    </div>
</div>

<div class=\"row\">
    <div class=\"form-group col-sm-6\">
        {{ form.label('telefono', 'Teléfono', { class:'control-label' }) }}
        {{ form.text('telefono', cliente.telefono, { class:'form-control' }) }}
    </div>
    <div class=\"form-group col-sm-6\">
        {{ form.label('email', 'E-Mail', { class:'control-label' }) }}
        {{ form.text('email', cliente.email, { class:'form-control' }) }}
    </div>
</div>

<div class=\"panel panel-default\">
    <div class=\"panel-heading\">Días de visita</div>
    <div class=\"panel-body\">
        <div class=\"row\">
            <div class=\"form-group col-sm-12\">
                {% for key, dia in dias %}
                    {{ form.checkbox(dia, cliente.dias_visita b-and key, { name: 'dias_visita[]', value: key }) }}
                {% endfor %}
            </div>
        </div>
    </div>
</div>

<div class=\"panel panel-default\">
    <div class=\"panel-heading\">Dirección de facturación</div>
    <div class=\"panel-body\">
        <div class=\"row\">
            <div class=\"form-group col-sm-12\">
                {{ form.label('domicilio', 'Domicilio', { class:'control-label' }) }}
                {{ form.text('domicilio', cliente.domicilio, { class:'form-control' }) }}
            </div>
        </div>

        <div class=\"row\">
            <div class=\"form-group col-sm-8\">
                {{ form.label('localidad', 'Localidad', { class:'control-label' }) }}
                {{ form.text('localidad', cliente.localidad, { class:'form-control' }) }}
            </div>
            <div class=\"form-group col-sm-4\">
                {{ form.label('cp', 'Cód. Postal', { class:'control-label' }) }}
                {{ form.text('cp', cliente.cp, { class:'form-control' }) }}
            </div>
        </div>
    </div>
</div>

<div class=\"panel panel-default\">
    <div class=\"panel-heading\">Dirección de entrega</div>
    <div class=\"panel-body\">
        <div class=\"row\">
            <div class=\"form-group col-sm-12\">
                {{ form.label('domicilio-entrega', 'Domicilio', { class: 'control-label' }) }}
                {{ form.text('domicilio-entrega', cliente.domicilio_entrega, { class: 'form-control' }) }}
            </div>
        </div>

        <div class=\"row\">
            <div class=\"form-group col-sm-8\">
                {{ form.label('localidad-entrega', 'Localidad', { class: 'control-label' }) }}
                {{ form.text('localidad-entrega', cliente.localidad_entrega, { class: 'form-control' }) }}
            </div>
            <div class=\"form-group col-sm-4\">
                {{ form.label('cp-entrega', 'Código postal', { class: 'control-label' }) }}
                {{ form.text('cp-entrega', cliente.cp_entrega, { class: 'form-control' }) }}
            </div>
        </div>
    </div>
</div>

<div class=\"row\">
    <div class=\"form-group required col-sm-6\">
        {{ form.label('grupo', 'Grupo', { class:'control-label' }) }}
        {{ form.select('grupo', grupos, cliente.grupo_id, { class:'form-control', required:'' }) }}
    </div>
    <div class=\"form-group required col-sm-6\">
        {{ form.label('forma-pago', 'Forma de pago', { class:'control-label' }) }}
        {{ form.select('forma-pago', formas_pago, cliente.forma_pago_id, { class:'form-control', required:'' }) }}
    </div>
</div>

<div class=\"row\">
    <div class=\"form-group col-sm-12\">
        {{ form.label('notas', 'Notas', { class:'control-label' }) }}
        {{ form.textarea('notas', cliente.notas, { class:'form-control', rows:'4' }) }}
    </div>
</div>

<div class=\"row\">
    <div class=\"form-group col-sm-12\">
        {{ form.label('adv', 'Advertencias', { class:'control-label' }) }}
        {{ form.textarea('adv', cliente.adv, { class:'form-control bg-adv', rows:'4' }) }}
    </div>
</div>
", "cliente/_tab_detalle.twig", "G:\\www\\quiosco\\app\\Views\\cliente\\_tab_detalle.twig");
    }
}
