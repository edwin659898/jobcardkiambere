import{B as k}from"./Authenticated-6f933b77.js";import{H as S,L as q,U as h,q as _,o as r,g as n,a as b,w as B,F as c,d as e,t as o,k as u,f as g,h as p,V as y,s as m,x as j,n as D}from"./app-7d6d683b.js";import{_ as V}from"./Record-edaaab17.js";import{Z as A}from"./main-18b6a265.js";import{_ as J}from"./_plugin-vue_export-helper-c27b6911.js";const C={components:{BreezeAuthenticatedLayout:k,Head:S,Link:q,Datepicker:A,Record:V},props:{Jobcard:Object,success:String,BeginDate:String,BedNumbers:Object},data(){return{form:this.$inertia.form({start_date:this.$props.BeginDate,name:"",uom:"",quantity:""})}},methods:{update(l){this.form.patch(`/potting/pots-arranging-in-seedbeds/${l}`,{onSuccess:()=>{this.form.name="",this.form.uom="",this.form.quantity=""},preserveScroll:!0})},complete(l){h.Inertia.get(route("complete.labelling",l))},destroy(l){confirm("Are you sure you want to remove")&&h.Inertia.delete(route("destroy.compartment",l))},format_date(l){if(l)return moment(String(l)).format("DD-MM-YYYY")}}},M={class:"content-wrapper"},N=e("div",{class:"content-header"},[e("div",{class:"container-fluid"},[e("div",{class:"row mb-2"},[e("div",{class:"col-sm-6"},[e("h1",{class:"m-0"}," Job Card for Mukau Production ")]),e("div",{class:"col-sm-6"},[e("ol",{class:"breadcrumb float-sm-right"},[e("li",{class:"breadcrumb-item"},"Home"),e("li",{class:"breadcrumb-item active"},"job-card ")])])])])],-1),L={class:"content"},O={class:"container-fluid text-sm"},U={class:"row"},H={class:"col-lg-12 connectedSortable"},z={class:"py-6"},Y={class:"max-w-7xl mx-auto sm:px-6 lg:px-8"},P={class:"bg-white overflow-hidden shadow-sm sm:rounded-lg"},F={class:"p-4 bg-white border-b border-gray-200"},I={class:"card-header flex justify-between"},R=e("h3",{class:"card-title"},"Job Card Review",-1),T={class:"card-body"},Z={key:0,class:"p-2 mb-1 text-sm text-blue-700 bg-blue-100 rounded-lg",role:"alert"},E={class:"col-sm-12 pt-8"},Q={class:"form-group"},G={key:0,class:"text-xs text-red-600 mt-2"},K={class:"form-group flex items-center justify-between space-x-2"},W={class:"w-full"},X=["value"],$={key:0,class:"text-xs text-red-600 mt-2"},ee={class:"w-full"},te=["value"],se={key:0,class:"text-xs text-red-600 mt-2"},oe={class:"w-full"},re={key:0,class:"text-xs text-red-600 mt-2"},ne={class:"flex justify-end"},ie=["disabled"],le={class:"table-responsive"},de={class:"table table-hover text-nowrap mt-6"},ae=e("thead",null,[e("tr",null,[e("th",null,"No"),e("th",null,"Seedling Bed Number"),e("th",null,"Quantity"),e("th",null,"UOM"),e("th",null,"Date")])],-1),ce={class:"flex flex-col justify-between pt-12"},ue={class:"flex justify-center"},me={class:"block bg-white max-w-sm text-center"},fe=e("div",{class:"py-2 px-6 border-b border-gray-300"}," Signature ",-1),_e={class:"p-6"},be=e("p",{class:"text-gray-700 text-xs mb-4"}," Activity Owner ",-1),pe={class:"mt-2 text-sm font-bold"},he={class:"flex justify-end mt-4"};function ge(l,i,d,ye,s,f){const v=_("Head"),x=_("Datepicker"),w=_("BreezeAuthenticatedLayout");return r(),n(c,null,[b(v,{title:"Operational Planning"}),b(w,null,{default:B(()=>[e("div",M,[N,e("section",L,[e("div",O,[e("div",U,[e("section",H,[e("div",z,[e("div",Y,[e("div",P,[e("div",F,[e("div",I,[R,e("p",null,"Site: "+o(d.Jobcard.site),1)]),e("div",T,[d.success?(r(),n("div",Z,o(d.success),1)):u("",!0),e("form",{onSubmit:i[5]||(i[5]=g(t=>f.update(d.Jobcard.id),["prevent"]))},[e("div",E,[e("div",Q,[e("label",null,o(l.$page.props.ActivityTitle),1),b(x,{modelValue:s.form.start_date,"onUpdate:modelValue":i[0]||(i[0]=t=>s.form.start_date=t),position:"left",altPosition:""},null,8,["modelValue"]),s.form.errors.start_date?(r(),n("p",G,o(s.form.errors.start_date),1)):u("",!0)]),e("div",K,[e("div",W,[p(e("select",{"onUpdate:modelValue":i[1]||(i[1]=t=>s.form.name=t),required:"",class:"w-full py-1 text-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"},[(r(!0),n(c,null,m(d.BedNumbers,(t,a)=>(r(),n("option",{key:a,value:t},o(t),9,X))),128))],512),[[y,s.form.name]]),s.form.errors.name?(r(),n("p",$,o(s.form.errors.name),1)):u("",!0)]),e("div",ee,[p(e("select",{"onUpdate:modelValue":i[2]||(i[2]=t=>s.form.uom=t),required:"",class:"w-full py-1 text-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"},[(r(!0),n(c,null,m(l.$page.props.uom,(t,a)=>(r(),n("option",{key:a,value:t},o(t),9,te))),128))],512),[[y,s.form.uom]]),s.form.errors.uom?(r(),n("p",se,o(s.form.errors.uom),1)):u("",!0)]),e("div",oe,[p(e("input",{type:"number","onUpdate:modelValue":i[3]||(i[3]=t=>s.form.quantity=t),step:".01",placeholder:"quantity",required:"",class:"w-full py-1 text-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"},null,512),[[j,s.form.quantity]]),s.form.errors.quantity?(r(),n("p",re,o(s.form.errors.quantity),1)):u("",!0)])]),e("div",ne,[e("button",{class:D([{"opacity-25":s.form.processing},"inline-flex justify-center rounded-md border border-transparent px-3 py-1 bg-blue-600 text-base leading-6 font-medium text-white shadow-sm hover:bg-blue-500 focus:outline-none focus:border-blue-700 focus:shadow-outline-blue transition ease-in-out duration-150 sm:text-sm sm:leading-5"]),disabled:s.form.processing}," Save ",10,ie)]),e("div",le,[e("table",de,[ae,e("tbody",null,[(r(!0),n(c,null,m(d.Jobcard.bed_prep,(t,a)=>(r(),n("tr",{key:a},[e("td",null,o(a+1),1),e("td",null,o(t.name),1),e("td",null,o(t.quantity),1),e("td",null,o(t.uom),1),e("td",null,o(f.format_date(t.created_at)),1)]))),128))])])]),e("div",ce,[e("div",ue,[e("div",me,[fe,e("div",_e,[be,(r(!0),n(c,null,m(d.Jobcard.childactivity.roles,t=>(r(),n("div",{key:t.id,class:"flex items-center space-x-1"},[e("p",pe,o(t.role),1)]))),128))])])])]),e("div",he,[e("button",{onClick:i[4]||(i[4]=g(t=>f.complete(d.Jobcard.id),["prevent"])),class:"inline-flex justify-center rounded-md border border-transparent px-4 py-2 bg-green-600 text-base leading-6 font-medium text-white shadow-sm hover:bg-green-500 focus:outline-none focus:border-green-700 focus:shadow-outline-green transition ease-in-out duration-150 sm:text-sm sm:leading-5"},"Sign and Save")])])],32)])])])])])])])])])])]),_:1})],64)}const qe=J(C,[["render",ge]]);export{qe as default};
