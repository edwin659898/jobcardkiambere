import{B as k}from"./Authenticated-6ca149e0.js";import{H as q,L as S,U as b,q as _,o as i,g as n,a as f,w as j,F as u,d as e,t as o,k as a,f as g,h as p,x as y,V,s as h,n as B}from"./app-c03fa087.js";import{_ as C}from"./Record-c0052f72.js";import{Z as N}from"./main-9361634d.js";import{_ as J}from"./_plugin-vue_export-helper-c27b6911.js";const A={components:{BreezeAuthenticatedLayout:k,Head:q,Link:S,Datepicker:N,Record:C},props:{Jobcard:Object,success:String,BeginDate:String,Name:String,Users:Object},data(){return{form:this.$inertia.form({start_date:this.$props.BeginDate,item_name:"",uom:"",quantity:"",received_by:"",type:this.$props.Name})}},methods:{update(l){this.form.patch(`/seed-bed-preparation/material-acqusition-from-store/${l}`,{onSuccess:()=>{this.form.item_name="",this.form.uom="",this.form.quantity=""},preserveScroll:!0})},complete(l){b.Inertia.get(route("complete.labelling",l))},destroy(l){confirm("Are you sure you want to remove")&&b.Inertia.delete(route("destroy.compartment",l))}}},D={class:"content-wrapper"},L=e("div",{class:"content-header"},[e("div",{class:"container-fluid"},[e("div",{class:"row mb-2"},[e("div",{class:"col-sm-6"},[e("h1",{class:"m-0"}," Job Card for Mukau Production ")]),e("div",{class:"col-sm-6"},[e("ol",{class:"breadcrumb float-sm-right"},[e("li",{class:"breadcrumb-item"},"Home"),e("li",{class:"breadcrumb-item active"},"job-card ")])])])])],-1),U={class:"content"},H={class:"container-fluid text-sm"},M={class:"row"},z={class:"col-lg-12 connectedSortable"},P={class:"py-6"},I={class:"max-w-7xl mx-auto sm:px-6 lg:px-8"},O={class:"bg-white overflow-hidden shadow-sm sm:rounded-lg"},F={class:"p-4 bg-white border-b border-gray-200"},R={class:"card-header flex justify-between"},T=e("h3",{class:"card-title"},"Job Card Review",-1),Z={class:"card-body"},E={key:0,class:"p-2 mb-1 text-sm text-blue-700 bg-blue-100 rounded-lg",role:"alert"},Q={class:"col-sm-12 pt-8"},G={class:"form-group"},K={key:0,class:"text-xs text-red-600 mt-2"},W={class:"form-group flex items-center justify-between space-x-2"},X={class:"w-full"},Y={key:0,class:"text-xs text-red-600 mt-2"},$={class:"w-full"},ee=["value"],te={key:0,class:"text-xs text-red-600 mt-2"},se={class:"w-full"},oe={key:0,class:"text-xs text-red-600 mt-2"},re={class:"flex justify-end"},ie=["disabled"],ne={class:"table-responsive"},le={class:"table table-hover text-nowrap mt-6"},de=e("th",null,"No",-1),ae=e("th",null,"Quantity",-1),ce=e("th",null,"Action",-1),ue=["onClick"],me={class:"flex flex-col justify-between pt-12"},_e={class:"flex justify-center"},fe={class:"block bg-white max-w-sm text-center"},pe=e("div",{class:"py-2 px-6 border-b border-gray-300"}," Signature ",-1),he={class:"p-6"},be=e("p",{class:"text-gray-700 text-xs mb-4"}," Persons to sign ",-1),ge={class:"mt-2 text-sm font-bold"},ye={class:"flex justify-end mt-4"};function xe(l,r,d,ve,s,m){const x=_("Head"),v=_("Datepicker"),w=_("BreezeAuthenticatedLayout");return i(),n(u,null,[f(x,{title:"Operational Planning"}),f(w,null,{default:j(()=>[e("div",D,[L,e("section",U,[e("div",H,[e("div",M,[e("section",z,[e("div",P,[e("div",I,[e("div",O,[e("div",F,[e("div",R,[T,e("p",null,"Site: "+o(d.Jobcard.site),1)]),e("div",Z,[d.success?(i(),n("div",E,o(d.success),1)):a("",!0),e("form",{onSubmit:r[5]||(r[5]=g(t=>m.update(d.Jobcard.id),["prevent"]))},[e("div",Q,[e("div",G,[e("label",null,o(l.$page.props.ActivityTitle),1),f(v,{modelValue:s.form.start_date,"onUpdate:modelValue":r[0]||(r[0]=t=>s.form.start_date=t),position:"left",altPosition:""},null,8,["modelValue"]),s.form.errors.start_date?(i(),n("p",K,o(s.form.errors.start_date),1)):a("",!0)]),e("div",W,[e("div",X,[p(e("input",{type:"text","onUpdate:modelValue":r[1]||(r[1]=t=>s.form.item_name=t),placeholder:"Item Name",required:"",class:"w-full py-1 text-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"},null,512),[[y,s.form.item_name]]),s.form.errors.item_name?(i(),n("p",Y,o(s.form.errors.item_name),1)):a("",!0)]),e("div",$,[p(e("select",{"onUpdate:modelValue":r[2]||(r[2]=t=>s.form.uom=t),required:"",class:"w-full py-1 text-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"},[(i(!0),n(u,null,h(l.$page.props.uom,(t,c)=>(i(),n("option",{key:c,value:t},o(t),9,ee))),128))],512),[[V,s.form.uom]]),s.form.errors.uom?(i(),n("p",te,o(s.form.errors.uom),1)):a("",!0)]),e("div",se,[p(e("input",{type:"number","onUpdate:modelValue":r[3]||(r[3]=t=>s.form.quantity=t),step:".01",placeholder:"quantity",required:"",class:"w-full py-1 text-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"},null,512),[[y,s.form.quantity]]),s.form.errors.quantity?(i(),n("p",oe,o(s.form.errors.quantity),1)):a("",!0)])]),e("div",re,[e("button",{class:B([{"opacity-25":s.form.processing},"inline-flex justify-center rounded-md border border-transparent px-3 py-1 bg-blue-600 text-base leading-6 font-medium text-white shadow-sm hover:bg-blue-500 focus:outline-none focus:border-blue-700 focus:shadow-outline-blue transition ease-in-out duration-150 sm:text-sm sm:leading-5"]),disabled:s.form.processing}," Save ",10,ie)]),e("div",ne,[e("table",le,[e("thead",null,[e("tr",null,[de,e("th",null,"Name of "+o(this.$props.Name),1),ae,ce])]),e("tbody",null,[(i(!0),n(u,null,h(d.Jobcard.bed_prep,(t,c)=>(i(),n("tr",{key:c},[e("td",null,o(c+1),1),e("td",null,o(t.name),1),e("td",null,o(t.quantity),1),e("td",null,[e("i",{onClick:we=>m.destroy(t.id),class:"fas fa-trash cursor-pointer text-red-500 hover:text-red-800"},null,8,ue)])]))),128))])])]),e("div",me,[e("div",_e,[e("div",fe,[pe,e("div",he,[be,(i(!0),n(u,null,h(d.Jobcard.childactivity.roles,t=>(i(),n("div",{key:t.id,class:"flex items-center space-x-1"},[e("p",ge,o(t.role),1)]))),128))])])])]),e("div",ye,[e("button",{onClick:r[4]||(r[4]=g(t=>m.complete(d.Jobcard.id),["prevent"])),class:"inline-flex justify-center rounded-md border border-transparent px-4 py-2 bg-green-600 text-base leading-6 font-medium text-white shadow-sm hover:bg-green-500 focus:outline-none focus:border-green-700 focus:shadow-outline-green transition ease-in-out duration-150 sm:text-sm sm:leading-5"},"Sign and Save")])])],32)])])])])])])])])])])]),_:1})],64)}const Be=J(A,[["render",xe]]);export{Be as default};
