<template>
  <div class="">
    <table class="table">
      <tr >
          <td v-for="tiplan in tiplanes">
            <img :src="'/'+tiplan.icono" alt="">
            <label>{{ tiplan.ntiplan }}</label>
          </td>
      </tr>
    </table>
    <div class="col-md-12">
      <div class="panel panel-default">

        <div class="panel-body">

          <ul class="nav nav-tabs" >
              <li v-for="plan in planes" :data-treeview="'#treeview_cplan_' + plan.li_attr.cplan">
                <a data-toggle="tab" @click="changeSelectTaskTree(plan.li_attr.cplan)" :href="'#cplan_'+plan.li_attr.cplan">{{ plan.text }}</a>
              </li>
          </ul>

          <input type="text" id="treeview_find" value="" placeholder="Buscar..." class="input" style="margin:0em auto 1em auto; display:block; padding:4px; border-radius:4px; border:1px solid silver;">

          <div class="tab-content" >
              <div v-for="plan in planes" :id="'cplan_' + plan.li_attr.cplan" class="tab-pane fade" :data-treeview="'#treeview_cplan_' + plan.li_attr.cplan">
                <div :id="'treeview_cplan_' + plan.li_attr.cplan" style="overflow: overlay;min-height: 300px;"></div>
              </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>


export default {
  name: 'select-task',
  props: {
    tiplanes: {type: Array,},
    planes: {type: Array,},
  },
  methods : {
    changeSelectTaskTree : function(id){
      console.warn(id)
      this.$emit("ctt",id)
    },
    recolored: function (evt, data){
        //$(".nav.nav-tabs").find("a").first().trigger("click")
        //$(".nav.nav-tabs").find("a").first().click()
        $("[data-state]").toArray().forEach(li => {
            var color = $(li).data("color")
            $(li).find("a").first().find("i").first().css({borderRightColor: color,borderRightWidth: "8px",borderRightStyle: "solid"})
        })
    },
    returnTask: function (evt, data){
      var vm = this.$root
      var tarea = $(vm.treetask_select).jstree('get_selected',true)[0]

      var mensaje = ""
      if ( window.FIND_TASK ){
        if( ! tarea.li_attr.ctarea ) return alertify.warning("No Selecciono una Tarea")
        var rvalue = tarea.li_attr.ctarea
        mensaje = "Desea Escoger esta Tarea"
      }else if ( window.FIND_PLAN ){
        if( ! tarea.li_attr.cplan ) return alertify.warning("No Selecciono un Plan ")
        if( window.TYPE_PLAN ){
          if ( tarea.li_attr.ctiplan != window.TYPE_PLAN ) return alertify.warning("El Plan no es del tipo Correspondiente ")
        }
        var rvalue = tarea.li_attr.cplan
        mensaje = "Desea Escoger este Plan"
      }

      //tarea.li_attr.ctarea
      alertify.confirm(mensaje,function(){
        window.opener.$(window.INPUT_REFERENCE)
          .val(rvalue)
          .focus()
          .trigger("change")

        window.close()
      })
    },
  },
  mounted :function(){
    this.$emit("tt_mounted")
  },
  updated :function(){
      var component = this
      var vm = this.$root
      $.jstree.defaults.contextmenu.items = {
        showDetail : {
          action : function(){
            var item = $(vm.treetask_select).jstree('get_selected',true)[0]
            if ( item.li_attr.cplan ){
              window.open("/planes/status/__cplan__".set("__cplan__",item.li_attr.cplan))
            }else{
              alertify.warning("Este item no es un Plan")
            }

          },
          label : "Ver en Detalle"
        },
        reprogramTask : {
          action : function(){
            var item = $(vm.treetask_select).jstree('get_selected',true)[0]
            if ( item.li_attr.ctarea ){
              alertify.warning("Opcion en Desarrollo")

            }else{
              alertify.warning("Este item no es Una Tarea")
            }
          },
          label : "Reprogramar Tarea"
        },
        edit : {
          action : function(){
            var item = $(vm.treetask_select).jstree('get_selected',true)[0]
            if ( item.li_attr.ctarea ){
              window.open("/tareas/edit/"+item.li_attr.ctarea)
            }else{
              alertify.warning("La opcion de Edición de Planes aun no se encuentra habilitada.")
            }
          },
          label : "Editar"
        }
      }
      for ( var plan of this.planes ){
        var select_treeview = "#treeview_cplan_"+plan.li_attr.cplan
        $(select_treeview).jstree({
          "plugins" : [ "search" , "contextmenu", "types"],
          "types" : {
            "modulo" : {
              "icon" : "/vendor/jstree/img/module.png"
            },
            "tareas" : {
              "icon" : "/vendor/jstree/img/task.png"
            },
            "componente" : {
              "icon" : "/vendor/jstree/img/component.png"
            },
            "elemento" : {
              "icon" : "/vendor/jstree/img/element.png"
            },
            "prod_minimo" : {
              "icon" : "/vendor/jstree/img/product.png"
            },
          },
          'core' : { 'data' : plan },
        })
        if ( window.ASIES_IS_WIN_POPUOT ) $(select_treeview).on('changed.jstree', component.returnTask)
        $(select_treeview).on('open_node.jstree', component.recolored)
        $(select_treeview).on('ready.jstree', component.recolored)

      }
      var to = false;
      $('#treeview_find').keyup(() => {
        if(to) { clearTimeout(to); }
        to = setTimeout(() => {
          var v = $('#treeview_find').val();
          $(this.$root.treetask_select).jstree(true).search(v);
        }, 250);
      });

  }
}
</script>

<style>
</style>
