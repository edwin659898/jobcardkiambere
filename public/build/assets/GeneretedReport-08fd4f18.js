import{B as y}from"./Authenticated-6f933b77.js";import{H as g,U as b,q as m,o as s,g as l,a as p,w as f,F as a,d as e,t as n,k as c,f as w,h as k,V as T,s as u,e as A}from"./app-7d6d683b.js";import{_ as D}from"./_plugin-vue_export-helper-c27b6911.js";const H={components:{BreezeAuthenticatedLayout:y,Head:g},props:{success:String,ParentActivity:Object,Trees:Object,Tree:String,JobCard:Object},data(){return{tree:this.$props.Tree}},methods:{search(){b.Inertia.get(route("view.report",{id:this.$props.ParentActivity.id,item:this.$props.JobCard,Tree:this.tree},{preserveState:!0,replace:!0}))},ExcelExport(){b.Inertia.get(route("excel.export",{id:this.$props.ParentActivity.id,item:this.$props.JobCard,Tree:this.tree},{preserveState:!0,replace:!0}))}}},C={class:"content-wrapper"},L=e("div",{class:"content-header"},[e("div",{class:"container-fluid"},[e("div",{class:"row mb-2"},[e("div",{class:"col-sm-6"},[e("h1",{class:"m-0"}," Dashboard ")]),e("div",{class:"col-sm-6"},[e("ol",{class:"breadcrumb float-sm-right"},[e("li",{class:"breadcrumb-item"},"Home"),e("li",{class:"breadcrumb-item active"},"Dashboard")])])])])],-1),S={class:"content"},B={class:"container-fluid"},E={class:"row"},M={class:"col-lg-12 connectedSortable"},N={class:"py-6"},j={class:"max-w-7xl mx-auto sm:px-6 lg:px-8"},P={class:"bg-white overflow-hidden shadow-sm sm:rounded-lg"},V={class:"p-4 bg-white border-b border-gray-200"},O={key:0,class:"p-2 mb-4 text-sm text-blue-700 bg-blue-100 rounded-lg dark:bg-blue-200 dark:text-blue-800",role:"alert"},q={class:"border-b px-4 py-3 flex justify-between"},z={class:"card-title"},F=e("option",{value:""},"-- Filter by Tree --",-1),I=["value"],J={class:"card-body"},U={key:0,class:"text-xs mt-1 text-blue-500"},K={key:1,class:"text-xs mt-1 text-red-500"},Q={key:0,class:"mt-1 px-3 py-2"},G={class:"table-responsive"},R={class:"table table-hover text-nowrap mt-6"},W=e("thead",null,[e("tr",null,[e("th",null,"ID"),e("th",null,"Tree Number"),e("th",null,"Quantity (Kg)"),e("th",null,"Damaged (Kg)")])],-1),X={key:1,class:"mt-1 px-3 py-2"},Y={class:"table-responsive"},Z={class:"table table-hover text-nowrap mt-6"},$=e("thead",null,[e("tr",null,[e("th",null,"No"),e("th",null,"Name"),e("th",null,"Quantity"),e("th",null,"UOM"),e("th",null,"Area")])],-1),ee={key:2,class:"flex justify-center"},te={class:"block bg-white text-center"},se={class:"p-6"},le=e("p",{class:"text-gray-700 text-xs mb-2"}," Persons who signed ",-1),ne={key:0,class:"flex justify-between items-center space-x-2"},oe=["innerHTML"],re=["innerHTML"];function ae(de,r,d,ie,_,h){const x=m("Head"),v=m("BreezeAuthenticatedLayout");return s(),l(a,null,[p(x,{title:"Dashboard"}),p(v,null,{default:f(()=>[e("div",C,[L,e("section",S,[e("div",B,[e("div",E,[e("section",M,[e("div",N,[e("div",j,[e("div",P,[e("div",V,[d.success?(s(),l("div",O,n(d.success),1)):c("",!0),e("div",q,[e("h4",z,n(d.ParentActivity.parent_title),1),e("button",{onClick:r[0]||(r[0]=w(t=>h.ExcelExport(),["prevent"])),class:"btn btn-success mr-1 cursor-pointer"},"Export"),k(e("select",{"onUpdate:modelValue":r[1]||(r[1]=t=>_.tree=t),onChange:r[2]||(r[2]=t=>h.search()),class:"form-control text-sm w-64"},[F,(s(!0),l(a,null,u(d.Trees,t=>(s(),l("option",{key:t.id,value:t.id},n(t.tree_number),9,I))),128))],544),[[T,_.tree]])]),e("div",J,[(s(!0),l(a,null,u(d.ParentActivity.childs,t=>(s(),l("div",{key:t.id,class:"block p-6 bg-white border border-gray-200 rounded-lg shadow mt-2"},[e("div",null,[A(n(t.child_title)+" ",1),t.timelines.length?(s(),l("span",U," Start Date: "+n(t.timelines[0].start_date)+" End Date: "+n(t.timelines[0].end_date),1)):(s(),l("span",K," This activity has not been done yet "))]),t.stocks.length?(s(),l("div",Q,[e("div",G,[e("table",R,[W,e("tbody",null,[(s(!0),l(a,null,u(t.stocks,(o,i)=>(s(),l("tr",{key:i},[e("td",null,n(i+1),1),e("td",null,n(o.fruit.tree.tree_number),1),e("td",null,n(o.quantity),1),e("td",null,n(o.damage_seed),1)]))),128))])])])])):c("",!0),t.bed_preparation.length?(s(),l("div",X,[e("div",Y,[e("table",Z,[$,e("tbody",null,[(s(!0),l(a,null,u(t.bed_preparation,(o,i)=>(s(),l("tr",{key:i},[e("td",null,n(i+1),1),e("td",null,n(o.name),1),e("td",null,n(o.quantity),1),e("td",null,n(o.uom),1),e("td",null,n(o.area_amount),1)]))),128))])])])])):c("",!0),t.timelines.length?(s(),l("div",ee,[e("div",te,[e("div",se,[le,(s(!0),l(a,null,u(t.signatures,o=>(s(),l("div",{key:o.id},[t.id==o.child_activity_id?(s(),l("div",ne,[e("label",{class:"mt-2.5 text-xs font-bold",innerHTML:o.role.role},null,8,oe),e("p",{class:"text-gray-400",innerHTML:o.user.name},null,8,re)])):c("",!0)]))),128))])])])):c("",!0)]))),128))])])])])])])])])])])]),_:1})],64)}const he=D(H,[["render",ae]]);export{he as default};