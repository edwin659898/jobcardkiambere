import{B as p}from"./Authenticated-6ca149e0.js";import{H as f,L as v,q as d,o as r,g as a,a as l,w as g,F as _,d as e,t as c,f as y,s as w,n as x,h as k,m as R}from"./app-c03fa087.js";import{_ as A}from"./_plugin-vue_export-helper-c27b6911.js";const B={components:{BreezeAuthenticatedLayout:p,Head:f,Link:v},props:{Activity:Object,Roles:Object,CurrentRoles:Object},data(){return{form:this.$inertia.form({checkedRoles:[]})}},mounted(){this.form.checkedRoles=this.CurrentRoles},methods:{updateRoles(s){this.form.patch(`/update/activity/roles/${s}`)}}},C={class:"content-wrapper"},L={class:"content-header"},H={class:"container-fluid"},z={class:"row mb-2"},S={class:"col-sm-6"},j={class:"m-0"},M={class:"col-sm-6"},O={class:"breadcrumb float-sm-right"},V=e("li",{class:"breadcrumb-item"},"Home",-1),D={class:"breadcrumb-item active"},E={class:"content text-sm"},F={class:"container-fluid"},N={class:"row"},q={class:"col-lg-12 connectedSortable"},U={class:"py-6"},G={class:"max-w-7xl mx-auto sm:px-6 lg:px-8"},I={class:"bg-white overflow-hidden shadow-sm sm:rounded-lg"},J={class:"p-4 bg-white border-b border-gray-200"},K={class:"card card-success card-outline"},P={class:"card-body box-profile"},Q={class:"profile-username text-center"},T={class:"list-group list-group-unbordered mb-3 mt-3"},W={class:"float-right"},X=["value"],Y=["disabled"];function Z(s,t,n,$,o,h){const u=d("Head"),m=d("BreezeAuthenticatedLayout");return r(),a(_,null,[l(u,{title:"Roles Management"}),l(m,null,{default:g(()=>[e("div",C,[e("div",L,[e("div",H,[e("div",z,[e("div",S,[e("h1",j,c(s.route().current()),1)]),e("div",M,[e("ol",O,[V,e("li",D,c(s.route().current()),1)])])])])]),e("section",E,[e("div",F,[e("div",N,[e("section",q,[e("div",U,[e("div",G,[e("div",I,[e("div",J,[e("div",K,[e("div",P,[e("h3",Q,c(n.Activity.child_title),1),e("form",{onSubmit:t[1]||(t[1]=y(i=>h.updateRoles(`${n.Activity.id}`),["prevent"]))},[e("ul",T,[(r(!0),a(_,null,w(n.Roles,i=>(r(),a("li",{class:"list-group-item",key:i.id},[e("b",null,c(i.role),1),e("a",W,[k(e("input",{type:"checkbox",value:i.id,"onUpdate:modelValue":t[0]||(t[0]=b=>o.form.checkedRoles=b),class:"order-none focus:ring-0 focus:shadow-none ring-offset-0 text-green-500"},null,8,X),[[R,o.form.checkedRoles]])])]))),128))]),e("button",{type:"submit",class:x(["bg-green-500 hover:bg-green-700 text-white btn btn-block",{"opacity-25":o.form.processing}]),disabled:o.form.processing},"Save",10,Y)],32)])])])])])])])])])])])]),_:1})],64)}const oe=A(B,[["render",Z]]);export{oe as default};