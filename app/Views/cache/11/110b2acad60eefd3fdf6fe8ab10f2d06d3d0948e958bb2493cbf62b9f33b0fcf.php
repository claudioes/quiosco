<?php

/* template/macro/form.twig */
class __TwigTemplate_e079c22700c80c8174871615e95a301957dd04c095f34c83de63a790a6ded3e2 extends Twig_Template
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
        // line 4
        echo "
";
        // line 8
        echo "
";
        // line 18
        echo "
";
        // line 31
        echo "
";
        // line 36
        echo "
";
        // line 41
        echo "
";
        // line 62
        echo "
";
        // line 73
        echo "
";
        // line 83
        echo "
";
        // line 95
        echo "
";
        // line 107
        echo "
";
        // line 119
        echo "
";
    }

    // line 1
    public function gethidden($__id__ = null, $__value__ = null, ...$__varargs__)
    {
        $context = $this->env->mergeGlobals(array(
            "id" => $__id__,
            "value" => $__value__,
            "varargs" => $__varargs__,
        ));

        $blocks = array();

        ob_start();
        try {
            // line 2
            echo "    <input type=\"hidden\" id=\"";
            echo twig_escape_filter($this->env, ($context["id"] ?? null), "html", null, true);
            echo "\" name=\"";
            echo twig_escape_filter($this->env, ($context["id"] ?? null), "html", null, true);
            echo "\" value=\"";
            echo twig_escape_filter($this->env, ($context["value"] ?? null), "html", null, true);
            echo "\">
";
        } catch (Exception $e) {
            ob_end_clean();

            throw $e;
        } catch (Throwable $e) {
            ob_end_clean();

            throw $e;
        }

        return ('' === $tmp = ob_get_clean()) ? '' : new Twig_Markup($tmp, $this->env->getCharset());
    }

    // line 5
    public function getstatic($__value__ = null, ...$__varargs__)
    {
        $context = $this->env->mergeGlobals(array(
            "value" => $__value__,
            "varargs" => $__varargs__,
        ));

        $blocks = array();

        ob_start();
        try {
            // line 6
            echo "    <p class=\"form-control-static\">";
            echo twig_escape_filter($this->env, ($context["value"] ?? null), "html", null, true);
            echo "</p>
";
        } catch (Exception $e) {
            ob_end_clean();

            throw $e;
        } catch (Throwable $e) {
            ob_end_clean();

            throw $e;
        }

        return ('' === $tmp = ob_get_clean()) ? '' : new Twig_Markup($tmp, $this->env->getCharset());
    }

    // line 9
    public function getlabel($__for__ = null, $__title__ = null, $__properties__ = null, ...$__varargs__)
    {
        $context = $this->env->mergeGlobals(array(
            "for" => $__for__,
            "title" => $__title__,
            "properties" => $__properties__,
            "varargs" => $__varargs__,
        ));

        $blocks = array();

        ob_start();
        try {
            // line 10
            echo "    <label
        class=\"";
            // line 11
            echo twig_escape_filter($this->env, $this->getAttribute(($context["properties"] ?? null), "class", array()), "html", null, true);
            echo "\"
        for=\"";
            // line 12
            echo twig_escape_filter($this->env, ($context["for"] ?? null), "html", null, true);
            echo "\"
        ";
            // line 13
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable(($context["properties"] ?? null));
            foreach ($context['_seq'] as $context["_prop"] => $context["_value"]) {
                // line 14
                echo "            ";
                echo twig_escape_filter($this->env, $context["_prop"], "html", null, true);
                echo "=\"";
                echo twig_escape_filter($this->env, $context["_value"], "html", null, true);
                echo "\"
        ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_prop'], $context['_value'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 16
            echo "    >";
            echo twig_escape_filter($this->env, ($context["title"] ?? null), "html", null, true);
            echo "</label>
";
        } catch (Exception $e) {
            ob_end_clean();

            throw $e;
        } catch (Throwable $e) {
            ob_end_clean();

            throw $e;
        }

        return ('' === $tmp = ob_get_clean()) ? '' : new Twig_Markup($tmp, $this->env->getCharset());
    }

    // line 19
    public function getinput($__type__ = null, $__id__ = null, $__value__ = null, $__properties__ = null, ...$__varargs__)
    {
        $context = $this->env->mergeGlobals(array(
            "type" => $__type__,
            "id" => $__id__,
            "value" => $__value__,
            "properties" => $__properties__,
            "varargs" => $__varargs__,
        ));

        $blocks = array();

        ob_start();
        try {
            // line 20
            echo "    <input
        type=\"";
            // line 21
            echo twig_escape_filter($this->env, ($context["type"] ?? null), "html", null, true);
            echo "\"
        class=\"";
            // line 22
            echo twig_escape_filter($this->env, $this->getAttribute(($context["properties"] ?? null), "class", array()), "html", null, true);
            echo "\"
        id=\"";
            // line 23
            echo twig_escape_filter($this->env, ($context["id"] ?? null), "html", null, true);
            echo "\"
        name=\"";
            // line 24
            echo twig_escape_filter($this->env, ($context["id"] ?? null), "html", null, true);
            echo "\"
        value=\"";
            // line 25
            echo twig_escape_filter($this->env, ($context["value"] ?? null), "html", null, true);
            echo "\"
        ";
            // line 26
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable(($context["properties"] ?? null));
            foreach ($context['_seq'] as $context["_prop"] => $context["_value"]) {
                // line 27
                echo "            ";
                echo twig_escape_filter($this->env, $context["_prop"], "html", null, true);
                echo "=\"";
                echo twig_escape_filter($this->env, $context["_value"], "html", null, true);
                echo "\"
        ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_prop'], $context['_value'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 29
            echo "    >
";
        } catch (Exception $e) {
            ob_end_clean();

            throw $e;
        } catch (Throwable $e) {
            ob_end_clean();

            throw $e;
        }

        return ('' === $tmp = ob_get_clean()) ? '' : new Twig_Markup($tmp, $this->env->getCharset());
    }

    // line 32
    public function gettext($__id__ = null, $__value__ = null, $__properties__ = null, ...$__varargs__)
    {
        $context = $this->env->mergeGlobals(array(
            "id" => $__id__,
            "value" => $__value__,
            "properties" => $__properties__,
            "varargs" => $__varargs__,
        ));

        $blocks = array();

        ob_start();
        try {
            // line 33
            echo "    ";
            $context["s"] = $this;
            // line 34
            echo "    ";
            echo $context["s"]->getinput("text", ($context["id"] ?? null), ($context["value"] ?? null), ($context["properties"] ?? null));
            echo "
";
        } catch (Exception $e) {
            ob_end_clean();

            throw $e;
        } catch (Throwable $e) {
            ob_end_clean();

            throw $e;
        }

        return ('' === $tmp = ob_get_clean()) ? '' : new Twig_Markup($tmp, $this->env->getCharset());
    }

    // line 37
    public function getpassword($__id__ = null, $__value__ = null, $__properties__ = null, ...$__varargs__)
    {
        $context = $this->env->mergeGlobals(array(
            "id" => $__id__,
            "value" => $__value__,
            "properties" => $__properties__,
            "varargs" => $__varargs__,
        ));

        $blocks = array();

        ob_start();
        try {
            // line 38
            echo "    ";
            $context["s"] = $this;
            // line 39
            echo "    ";
            echo $context["s"]->getinput("password", ($context["id"] ?? null), ($context["value"] ?? null), ($context["properties"] ?? null));
            echo "
";
        } catch (Exception $e) {
            ob_end_clean();

            throw $e;
        } catch (Throwable $e) {
            ob_end_clean();

            throw $e;
        }

        return ('' === $tmp = ob_get_clean()) ? '' : new Twig_Markup($tmp, $this->env->getCharset());
    }

    // line 42
    public function getselect($__id__ = null, $__values__ = null, $__value__ = null, $__properties__ = null, $__allowNull__ = null, ...$__varargs__)
    {
        $context = $this->env->mergeGlobals(array(
            "id" => $__id__,
            "values" => $__values__,
            "value" => $__value__,
            "properties" => $__properties__,
            "allowNull" => $__allowNull__,
            "varargs" => $__varargs__,
        ));

        $blocks = array();

        ob_start();
        try {
            // line 43
            echo "    <select
        id=\"";
            // line 44
            echo twig_escape_filter($this->env, ($context["id"] ?? null), "html", null, true);
            echo "\"
        name=\"";
            // line 45
            echo twig_escape_filter($this->env, ($context["id"] ?? null), "html", null, true);
            echo "\"
        class=\"";
            // line 46
            echo twig_escape_filter($this->env, $this->getAttribute(($context["properties"] ?? null), "class", array()), "html", null, true);
            echo "\"
        ";
            // line 47
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable(($context["properties"] ?? null));
            foreach ($context['_seq'] as $context["_prop"] => $context["_value"]) {
                // line 48
                echo "            ";
                echo twig_escape_filter($this->env, $context["_prop"], "html", null, true);
                echo "=\"";
                echo twig_escape_filter($this->env, $context["_value"], "html", null, true);
                echo "\"
        ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_prop'], $context['_value'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 50
            echo "    >
        ";
            // line 51
            if (((array_key_exists("allowNull", $context)) ? (_twig_default_filter(($context["allowNull"] ?? null), false)) : (false))) {
                // line 52
                echo "            <option value=\"\" selected>";
                echo twig_escape_filter($this->env, ($context["allowNull"] ?? null), "html", null, true);
                echo "</option>
        ";
            } else {
                // line 54
                echo "            <option value=\"\" disabled selected>Seleccione una opción</option>
        ";
            }
            // line 56
            echo "
        ";
            // line 57
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable(($context["values"] ?? null));
            foreach ($context['_seq'] as $context["key"] => $context["name"]) {
                // line 58
                echo "            <option value=\"";
                echo twig_escape_filter($this->env, $context["key"], "html", null, true);
                echo "\" ";
                echo (((($context["value"] ?? null) == $context["key"])) ? ("selected") : (""));
                echo " >";
                echo twig_escape_filter($this->env, $context["name"], "html", null, true);
                echo "</option>
        ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['key'], $context['name'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 60
            echo "    </select>
";
        } catch (Exception $e) {
            ob_end_clean();

            throw $e;
        } catch (Throwable $e) {
            ob_end_clean();

            throw $e;
        }

        return ('' === $tmp = ob_get_clean()) ? '' : new Twig_Markup($tmp, $this->env->getCharset());
    }

    // line 63
    public function gettextarea($__id__ = null, $__value__ = null, $__properties__ = null, ...$__varargs__)
    {
        $context = $this->env->mergeGlobals(array(
            "id" => $__id__,
            "value" => $__value__,
            "properties" => $__properties__,
            "varargs" => $__varargs__,
        ));

        $blocks = array();

        ob_start();
        try {
            // line 64
            echo "    <textarea
        id=\"";
            // line 65
            echo twig_escape_filter($this->env, ($context["id"] ?? null), "html", null, true);
            echo "\"
        name=\"";
            // line 66
            echo twig_escape_filter($this->env, ($context["id"] ?? null), "html", null, true);
            echo "\"
        class=\"";
            // line 67
            echo twig_escape_filter($this->env, $this->getAttribute(($context["properties"] ?? null), "class", array()), "html", null, true);
            echo "\"
        ";
            // line 68
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable(($context["properties"] ?? null));
            foreach ($context['_seq'] as $context["_prop"] => $context["_value"]) {
                // line 69
                echo "            ";
                echo twig_escape_filter($this->env, $context["_prop"], "html", null, true);
                echo "=\"";
                echo twig_escape_filter($this->env, $context["_value"], "html", null, true);
                echo "\"
        ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_prop'], $context['_value'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 71
            echo "    >";
            echo twig_escape_filter($this->env, ($context["value"] ?? null), "html", null, true);
            echo "</textarea>
";
        } catch (Exception $e) {
            ob_end_clean();

            throw $e;
        } catch (Throwable $e) {
            ob_end_clean();

            throw $e;
        }

        return ('' === $tmp = ob_get_clean()) ? '' : new Twig_Markup($tmp, $this->env->getCharset());
    }

    // line 74
    public function getcheckbox($__title__ = null, $__checked__ = null, $__properties__ = null, ...$__varargs__)
    {
        $context = $this->env->mergeGlobals(array(
            "title" => $__title__,
            "checked" => $__checked__,
            "properties" => $__properties__,
            "varargs" => $__varargs__,
        ));

        $blocks = array();

        ob_start();
        try {
            // line 75
            echo "    <label class=\"checkbox-inline\">
        <input type=\"checkbox\" ";
            // line 76
            echo ((((array_key_exists("checked", $context)) ? (_twig_default_filter(($context["checked"] ?? null), false)) : (false))) ? ("checked") : (""));
            echo "
            ";
            // line 77
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable(($context["properties"] ?? null));
            foreach ($context['_seq'] as $context["_prop"] => $context["_value"]) {
                // line 78
                echo "                ";
                echo twig_escape_filter($this->env, $context["_prop"], "html", null, true);
                echo "=\"";
                echo twig_escape_filter($this->env, $context["_value"], "html", null, true);
                echo "\"
            ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_prop'], $context['_value'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 80
            echo "        > ";
            echo twig_escape_filter($this->env, ($context["title"] ?? null), "html", null, true);
            echo "
    </label>
";
        } catch (Exception $e) {
            ob_end_clean();

            throw $e;
        } catch (Throwable $e) {
            ob_end_clean();

            throw $e;
        }

        return ('' === $tmp = ob_get_clean()) ? '' : new Twig_Markup($tmp, $this->env->getCharset());
    }

    // line 84
    public function getbutton($__id__ = null, $__text__ = null, $__properties__ = null, ...$__varargs__)
    {
        $context = $this->env->mergeGlobals(array(
            "id" => $__id__,
            "text" => $__text__,
            "properties" => $__properties__,
            "varargs" => $__varargs__,
        ));

        $blocks = array();

        ob_start();
        try {
            // line 85
            echo "    <button
        type=\"button\"
        class=\"";
            // line 87
            echo twig_escape_filter($this->env, $this->getAttribute(($context["properties"] ?? null), "class", array()), "html", null, true);
            echo "\"
        id=\"";
            // line 88
            echo twig_escape_filter($this->env, ($context["id"] ?? null), "html", null, true);
            echo "\"
        name=\"";
            // line 89
            echo twig_escape_filter($this->env, ($context["id"] ?? null), "html", null, true);
            echo "\"
        ";
            // line 90
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable(($context["properties"] ?? null));
            foreach ($context['_seq'] as $context["_prop"] => $context["_value"]) {
                // line 91
                echo "            ";
                echo twig_escape_filter($this->env, $context["_prop"], "html", null, true);
                echo "=\"";
                echo twig_escape_filter($this->env, $context["_value"], "html", null, true);
                echo "\"
        ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_prop'], $context['_value'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 93
            echo "    >";
            echo ($context["text"] ?? null);
            echo "</button>
";
        } catch (Exception $e) {
            ob_end_clean();

            throw $e;
        } catch (Throwable $e) {
            ob_end_clean();

            throw $e;
        }

        return ('' === $tmp = ob_get_clean()) ? '' : new Twig_Markup($tmp, $this->env->getCharset());
    }

    // line 96
    public function getsubmit($__id__ = null, $__text__ = null, $__properties__ = null, ...$__varargs__)
    {
        $context = $this->env->mergeGlobals(array(
            "id" => $__id__,
            "text" => $__text__,
            "properties" => $__properties__,
            "varargs" => $__varargs__,
        ));

        $blocks = array();

        ob_start();
        try {
            // line 97
            echo "    <button
        type=\"submit\"
        id=\"";
            // line 99
            echo twig_escape_filter($this->env, ($context["id"] ?? null), "html", null, true);
            echo "\"
        name=\"";
            // line 100
            echo twig_escape_filter($this->env, ($context["id"] ?? null), "html", null, true);
            echo "\"
        class=\"";
            // line 101
            echo twig_escape_filter($this->env, $this->getAttribute(($context["properties"] ?? null), "class", array()), "html", null, true);
            echo "\"
        ";
            // line 102
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable(($context["properties"] ?? null));
            foreach ($context['_seq'] as $context["_prop"] => $context["_value"]) {
                // line 103
                echo "            ";
                echo twig_escape_filter($this->env, $context["_prop"], "html", null, true);
                echo "=\"";
                echo twig_escape_filter($this->env, $context["_value"], "html", null, true);
                echo "\"
        ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_prop'], $context['_value'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 105
            echo "    >";
            echo ($context["text"] ?? null);
            echo "</button>
";
        } catch (Exception $e) {
            ob_end_clean();

            throw $e;
        } catch (Throwable $e) {
            ob_end_clean();

            throw $e;
        }

        return ('' === $tmp = ob_get_clean()) ? '' : new Twig_Markup($tmp, $this->env->getCharset());
    }

    // line 108
    public function getfile($__id__ = null, $__properties__ = null, ...$__varargs__)
    {
        $context = $this->env->mergeGlobals(array(
            "id" => $__id__,
            "properties" => $__properties__,
            "varargs" => $__varargs__,
        ));

        $blocks = array();

        ob_start();
        try {
            // line 109
            echo "    <input
        type=\"file\"
        class=\"";
            // line 111
            echo twig_escape_filter($this->env, $this->getAttribute(($context["properties"] ?? null), "class", array()), "html", null, true);
            echo "\"
        id=\"";
            // line 112
            echo twig_escape_filter($this->env, ($context["id"] ?? null), "html", null, true);
            echo "\"
        name=\"";
            // line 113
            echo twig_escape_filter($this->env, ($context["id"] ?? null), "html", null, true);
            echo "\"
        ";
            // line 114
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable(($context["properties"] ?? null));
            foreach ($context['_seq'] as $context["_prop"] => $context["_value"]) {
                // line 115
                echo "            ";
                echo twig_escape_filter($this->env, $context["_prop"], "html", null, true);
                echo "=\"";
                echo twig_escape_filter($this->env, $context["_value"], "html", null, true);
                echo "\"
        ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_prop'], $context['_value'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 117
            echo "    >
";
        } catch (Exception $e) {
            ob_end_clean();

            throw $e;
        } catch (Throwable $e) {
            ob_end_clean();

            throw $e;
        }

        return ('' === $tmp = ob_get_clean()) ? '' : new Twig_Markup($tmp, $this->env->getCharset());
    }

    // line 120
    public function getbuttonSaveCancel(...$__varargs__)
    {
        $context = $this->env->mergeGlobals(array(
            "varargs" => $__varargs__,
        ));

        $blocks = array();

        ob_start();
        try {
            // line 121
            echo "    <div class=\"form-group\">
        <div class=\"col-sm-offset-2 col-sm-10\">
            <button type=\"submit\" class=\"btn btn-success\"><i class=\"glyphicon glyphicon-ok\" style=\"margin-right: 0.5em;\"></i>Guardar</button>
            &nbsp;
            <a href=\"#\" onclick=\"history.back();\">Cancelar</a>
        </div>
    </div>
";
        } catch (Exception $e) {
            ob_end_clean();

            throw $e;
        } catch (Throwable $e) {
            ob_end_clean();

            throw $e;
        }

        return ('' === $tmp = ob_get_clean()) ? '' : new Twig_Markup($tmp, $this->env->getCharset());
    }

    public function getTemplateName()
    {
        return "template/macro/form.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  730 => 121,  719 => 120,  703 => 117,  692 => 115,  688 => 114,  684 => 113,  680 => 112,  676 => 111,  672 => 109,  659 => 108,  641 => 105,  630 => 103,  626 => 102,  622 => 101,  618 => 100,  614 => 99,  610 => 97,  596 => 96,  578 => 93,  567 => 91,  563 => 90,  559 => 89,  555 => 88,  551 => 87,  547 => 85,  533 => 84,  514 => 80,  503 => 78,  499 => 77,  495 => 76,  492 => 75,  478 => 74,  460 => 71,  449 => 69,  445 => 68,  441 => 67,  437 => 66,  433 => 65,  430 => 64,  416 => 63,  400 => 60,  387 => 58,  383 => 57,  380 => 56,  376 => 54,  370 => 52,  368 => 51,  365 => 50,  354 => 48,  350 => 47,  346 => 46,  342 => 45,  338 => 44,  335 => 43,  319 => 42,  301 => 39,  298 => 38,  284 => 37,  266 => 34,  263 => 33,  249 => 32,  233 => 29,  222 => 27,  218 => 26,  214 => 25,  210 => 24,  206 => 23,  202 => 22,  198 => 21,  195 => 20,  180 => 19,  162 => 16,  151 => 14,  147 => 13,  143 => 12,  139 => 11,  136 => 10,  122 => 9,  104 => 6,  92 => 5,  70 => 2,  57 => 1,  52 => 119,  49 => 107,  46 => 95,  43 => 83,  40 => 73,  37 => 62,  34 => 41,  31 => 36,  28 => 31,  25 => 18,  22 => 8,  19 => 4,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("{% macro hidden(id, value) %}
    <input type=\"hidden\" id=\"{{ id }}\" name=\"{{ id }}\" value=\"{{ value }}\">
{% endmacro %}

{% macro static(value) %}
    <p class=\"form-control-static\">{{ value }}</p>
{% endmacro %}

{% macro label(for, title, properties) %}
    <label
        class=\"{{ properties.class }}\"
        for=\"{{ for }}\"
        {% for _prop, _value in properties %}
            {{ _prop }}=\"{{ _value }}\"
        {% endfor %}
    >{{ title }}</label>
{% endmacro %}

{% macro input(type, id, value, properties) %}
    <input
        type=\"{{ type }}\"
        class=\"{{ properties.class }}\"
        id=\"{{ id }}\"
        name=\"{{ id }}\"
        value=\"{{ value }}\"
        {% for _prop, _value in properties %}
            {{ _prop }}=\"{{ _value }}\"
        {% endfor %}
    >
{% endmacro %}

{% macro text(id, value, properties) %}
    {% import _self as s %}
    {{ s.input('text', id, value, properties )}}
{% endmacro %}

{% macro password(id, value, properties) %}
    {% import _self as s %}
    {{ s.input('password', id, value, properties )}}
{% endmacro %}

{% macro select(id, values, value, properties, allowNull) %}
    <select
        id=\"{{ id }}\"
        name=\"{{ id }}\"
        class=\"{{ properties.class }}\"
        {% for _prop, _value in properties %}
            {{ _prop }}=\"{{ _value }}\"
        {% endfor %}
    >
        {% if allowNull|default(false) %}
            <option value=\"\" selected>{{ allowNull }}</option>
        {% else %}
            <option value=\"\" disabled selected>Seleccione una opción</option>
        {% endif %}

        {% for key, name in values %}
            <option value=\"{{ key }}\" {{ (value == key) ? 'selected': ''}} >{{ name }}</option>
        {% endfor %}
    </select>
{% endmacro %}

{% macro textarea(id, value, properties) %}
    <textarea
        id=\"{{ id }}\"
        name=\"{{ id }}\"
        class=\"{{ properties.class }}\"
        {% for _prop, _value in properties %}
            {{ _prop }}=\"{{ _value }}\"
        {% endfor %}
    >{{ value }}</textarea>
{% endmacro %}

{% macro checkbox(title, checked, properties) %}
    <label class=\"checkbox-inline\">
        <input type=\"checkbox\" {{ (checked|default(false)) ? 'checked' }}
            {% for _prop, _value in properties %}
                {{ _prop }}=\"{{ _value }}\"
            {% endfor %}
        > {{ title }}
    </label>
{% endmacro %}

{% macro button(id, text, properties) %}
    <button
        type=\"button\"
        class=\"{{ properties.class }}\"
        id=\"{{ id }}\"
        name=\"{{ id }}\"
        {% for _prop, _value in properties %}
            {{ _prop }}=\"{{ _value }}\"
        {% endfor %}
    >{{ text|raw }}</button>
{% endmacro %}

{% macro submit(id, text, properties) %}
    <button
        type=\"submit\"
        id=\"{{ id }}\"
        name=\"{{ id }}\"
        class=\"{{ properties.class }}\"
        {% for _prop, _value in properties %}
            {{ _prop }}=\"{{ _value }}\"
        {% endfor %}
    >{{ text|raw }}</button>
{% endmacro %}

{% macro file(id, properties) %}
    <input
        type=\"file\"
        class=\"{{ properties.class }}\"
        id=\"{{ id }}\"
        name=\"{{ id }}\"
        {% for _prop, _value in properties %}
            {{ _prop }}=\"{{ _value }}\"
        {% endfor %}
    >
{% endmacro %}

{% macro buttonSaveCancel() %}
    <div class=\"form-group\">
        <div class=\"col-sm-offset-2 col-sm-10\">
            <button type=\"submit\" class=\"btn btn-success\"><i class=\"glyphicon glyphicon-ok\" style=\"margin-right: 0.5em;\"></i>Guardar</button>
            &nbsp;
            <a href=\"#\" onclick=\"history.back();\">Cancelar</a>
        </div>
    </div>
{% endmacro %}
", "template/macro/form.twig", "G:\\www\\quiosco\\app\\Views\\template\\macro\\form.twig");
    }
}
