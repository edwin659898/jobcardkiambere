import{B as S}from"./Authenticated-6f933b77.js";import{H as V,L as j,U as h,q as m,o as r,g as n,a as f,w as q,F as u,d as e,t as o,k as c,f as g,h as p,V as y,s as _,x as N,n as C}from"./app-7d6d683b.js";import{Z as D}from"./main-18b6a265.js";import{s as M}from"./vue-multiselect.esm-22442a0d.js";import{_ as B}from"./_plugin-vue_export-helper-c27b6911.js";const J={components:{BreezeAuthenticatedLayout:S,Head:V,Link:j,Datepicker:D,VueMultiselect:M},props:{Jobcard:Object,success:String,BeginDate:String,Crates:Object,Trees:Object},data(){return{form:this.$inertia.form({start_date:this.$props.BeginDate,name:"",uom:"",quantity:"",treeNumber:""})}},methods:{update(l){this.form.patch(`/seedling-selection/arrange-seedlings-in-crate/${l}`,{onSuccess:()=>{this.form.name="",this.form.uom="",this.form.quantity="",this.form.treeNumber=""},preserveScroll:!0})},complete(l){h.Inertia.get(route("complete.labelling",l))},destroy(l){confirm("Are you sure you want to remove")&&h.Inertia.delete(route("destroy.compartment",l))},format_date(l){if(l)return moment(String(l)).format("DD-MM-YYYY")}}},U={class:"content-wrapper"},A=e("div",{class:"content-header"},[e("div",{class:"container-fluid"},[e("div",{class:"row mb-2"},[e("div",{class:"col-sm-6"},[e("h1",{class:"m-0"}," Job Card for Mukau Production ")]),e("div",{class:"col-sm-6"},[e("ol",{class:"breadcrumb float-sm-right"},[e("li",{class:"breadcrumb-item"},"Home"),e("li",{class:"breadcrumb-item active"},"job-card ")])])])])],-1),L={class:"content"},O={class:"container-fluid text-sm"},H={class:"row"},T={class:"col-lg-12 connectedSortable"},z={class:"py-6"},Y={class:"max-w-7xl mx-auto sm:px-6 lg:px-8"},P={class:"bg-white overflow-hidden shadow-sm sm:rounded-lg"},F={class:"p-4 bg-white border-b border-gray-200"},I={class:"card-header flex justify-between"},Z=e("h3",{class:"card-title"},"Job Card Review",-1),E={class:"card-body"},Q={key:0,class:"p-2 mb-1 text-sm text-blue-700 bg-blue-100 rounded-lg",role:"alert"},R={class:"col-sm-12 pt-8"},G={class:"form-group"},K={key:0,class:"text-xs text-red-600 mt-2"},W={class:"form-group flex items-center justify-between space-x-2"},X={class:"w-full"},$={key:0,class:"text-xs text-red-600 mt-2"},ee={class:"form-group flex items-center justify-between space-x-2"},te={class:"w-full"},se=["value"],oe={key:0,class:"text-xs text-red-600 mt-2"},re={class:"w-full"},ne=["value"],ie={key:0,class:"text-xs text-red-600 mt-2"},le={class:"w-full"},de={key:0,class:"text-xs text-red-600 mt-2"},ae={class:"flex justify-end"},ce=["disabled"],ue={class:"table-responsive"},me={class:"table table-hover text-nowrap mt-6"},fe=e("thead",null,[e("tr",null,[e("th",null,"No"),e("th",null,"Tree Number"),e("th",null,"Crate Number"),e("th",null,"UOM"),e("th",null,"Quantity"),e("th",null,"Date")])],-1),_e={class:"flex flex-col justify-between pt-12"},be={class:"flex justify-center"},pe={class:"block bg-white max-w-sm text-center"},he=e("div",{class:"py-2 px-6 border-b border-gray-300"}," Signature ",-1),ge={class:"p-6"},ye=e("p",{class:"text-gray-700 text-xs mb-4"}," Activity Owner ",-1),xe={class:"mt-2 text-sm font-bold"},ve={class:"flex justify-end mt-4"};function we(l,i,d,ke,s,b){const x=m("Head"),v=m("Datepicker"),w=m("VueMultiselect"),k=m("BreezeAuthenticatedLayout");return r(),n(u,null,[f(x,{title:"Operational Planning"}),f(k,null,{default:q(()=>[e("div",U,[A,e("section",L,[e("div",O,[e("div",H,[e("section",T,[e("div",z,[e("div",Y,[e("div",P,[e("div",F,[e("div",I,[Z,e("p",null,"Site: "+o(d.Jobcard.site),1)]),e("div",E,[d.success?(r(),n("div",Q,o(d.success),1)):c("",!0),e("form",{onSubmit:i[6]||(i[6]=g(t=>b.update(d.Jobcard.id),["prevent"]))},[e("div",R,[e("div",G,[e("label",null,o(l.$page.props.ActivityTitle),1),f(v,{modelValue:s.form.start_date,"onUpdate:modelValue":i[0]||(i[0]=t=>s.form.start_date=t),position:"left",altPosition:""},null,8,["modelValue"]),s.form.errors.start_date?(r(),n("p",K,o(s.form.errors.start_date),1)):c("",!0)]),e("div",W,[e("div",X,[f(w,{modelValue:s.form.treeNumber,"onUpdate:modelValue":i[1]||(i[1]=t=>s.form.treeNumber=t),"track-by":"id",options:d.Trees,label:"tree_number",searchable:!0},null,8,["modelValue","options"]),s.form.errors.treeNumber?(r(),n("p",$,o(s.form.errors.treeNumber),1)):c("",!0)])]),e("div",ee,[e("div",te,[p(e("select",{"onUpdate:modelValue":i[2]||(i[2]=t=>s.form.name=t),required:"",class:"w-full py-1 text-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"},[(r(!0),n(u,null,_(d.Crates,(t,a)=>(r(),n("option",{key:a,value:t},o(t),9,se))),128))],512),[[y,s.form.name]]),s.form.errors.name?(r(),n("p",oe,o(s.form.errors.name),1)):c("",!0)]),e("div",re,[p(e("select",{"onUpdate:modelValue":i[3]||(i[3]=t=>s.form.uom=t),required:"",class:"w-full py-1 text-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"},[(r(!0),n(u,null,_(l.$page.props.uom,(t,a)=>(r(),n("option",{key:a,value:t},o(t),9,ne))),128))],512),[[y,s.form.uom]]),s.form.errors.uom?(r(),n("p",ie,o(s.form.errors.uom),1)):c("",!0)]),e("div",le,[p(e("input",{type:"number","onUpdate:modelValue":i[4]||(i[4]=t=>s.form.quantity=t),step:".01",placeholder:"quantity",required:"",class:"w-full py-1 text-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"},null,512),[[N,s.form.quantity]]),s.form.errors.quantity?(r(),n("p",de,o(s.form.errors.quantity),1)):c("",!0)])]),e("div",ae,[e("button",{class:C([{"opacity-25":s.form.processing},"inline-flex justify-center rounded-md border border-transparent px-3 py-1 bg-blue-600 text-base leading-6 font-medium text-white shadow-sm hover:bg-blue-500 focus:outline-none focus:border-blue-700 focus:shadow-outline-blue transition ease-in-out duration-150 sm:text-sm sm:leading-5"]),disabled:s.form.processing}," Save ",10,ce)]),e("div",ue,[e("table",me,[fe,e("tbody",null,[(r(!0),n(u,null,_(d.Jobcard.bed_prep,(t,a)=>(r(),n("tr",{key:a},[e("td",null,o(a+1),1),e("td",null,o(t.tree.tree_number),1),e("td",null,o(t.name),1),e("td",null,o(t.uom),1),e("td",null,o(t.quantity),1),e("td",null,o(b.format_date(t.created_at)),1)]))),128))])])]),e("div",_e,[e("div",be,[e("div",pe,[he,e("div",ge,[ye,(r(!0),n(u,null,_(d.Jobcard.childactivity.roles,t=>(r(),n("div",{key:t.id,class:"flex items-center space-x-1"},[e("p",xe,o(t.role),1)]))),128))])])])]),e("div",ve,[e("button",{onClick:i[5]||(i[5]=g(t=>b.complete(d.Jobcard.id),["prevent"])),class:"inline-flex justify-center rounded-md border border-transparent px-4 py-2 bg-green-600 text-base leading-6 font-medium text-white shadow-sm hover:bg-green-500 focus:outline-none focus:border-green-700 focus:shadow-outline-green transition ease-in-out duration-150 sm:text-sm sm:leading-5"},"Sign and Save")])])],32)])])])])])])])])])])]),_:1})],64)}const Ce=B(J,[["render",we]]);export{Ce as default};
