import{B as k}from"./Authenticated-6f933b77.js";import{H as B,L as q,U as b,q as m,o as l,g as i,a as f,w as j,F as _,d as e,t as o,k as a,f as C,h,x as g,n as D,s as y}from"./app-7d6d683b.js";import{_ as V}from"./Record-edaaab17.js";import{Z as G}from"./main-18b6a265.js";import{s as J}from"./vue-multiselect.esm-22442a0d.js";import{_ as O}from"./_plugin-vue_export-helper-c27b6911.js";const A={components:{BreezeAuthenticatedLayout:k,Head:B,Link:q,Datepicker:G,Record:V,VueMultiselect:J},props:{Jobcard:Object,Users:Object,BeginDate:String,success:String},data(){return{form:this.$inertia.form({Goodquantity:null,Badquantity:null,SelectedId:null}),SelectedOne:!1,start_date:this.$props.BeginDate}},methods:{update(){this.form.patch(`/seed-extraction/sorting/${this.form.SelectedId}`,{onSuccess:()=>this.SelectedOne=!1,preserveScroll:!0})},complete(r){b.Inertia.get(route("complete.labelling",r))},destroy(r){confirm("Are you sure you want to remove")&&b.Inertia.delete(route("destroy.stockIssue",r))},selected(r){this.form.Goodquantity=null,this.form.Badquantity=null,this.SelectedOne=!0,this.form.SelectedId=r},format_date(r){if(r)return moment(String(r)).format("DD-MM-YYYY")}}},I={class:"content-wrapper"},L=e("div",{class:"content-header"},[e("div",{class:"container-fluid"},[e("div",{class:"row mb-2"},[e("div",{class:"col-sm-6"},[e("h1",{class:"m-0"}," Job Card for Mukau Production ")]),e("div",{class:"col-sm-6"},[e("ol",{class:"breadcrumb float-sm-right"},[e("li",{class:"breadcrumb-item"},"Home"),e("li",{class:"breadcrumb-item active"},"job-card ")])])])])],-1),M={class:"content"},N={class:"container-fluid text-sm"},H={class:"row"},U={class:"col-lg-12 connectedSortable"},z={class:"py-6"},P={class:"max-w-7xl mx-auto sm:px-6 lg:px-8"},R={class:"bg-white overflow-hidden shadow-sm sm:rounded-lg"},Y={class:"p-4 bg-white border-b border-gray-200"},T={class:"card-header flex justify-between"},F=e("h3",{class:"card-title"},"Job Card Review",-1),Z={class:"card-body"},E={key:0,class:"p-2 mb-1 text-sm text-blue-700 bg-blue-100 rounded-lg",role:"alert"},K={class:"col-sm-12 pt-8"},Q={class:"form-group"},W={class:"flex flex-col rounded-md shadow-lg px-3 py-2 pt-3"},X={key:0,class:"flex items-center justify-between space-x-2"},$=["disabled"],ee={key:1,class:"text-xs text-red-600 mt-2"},te={key:2,class:"text-xs text-red-600 mt-2"},oe={key:3,class:"text-xs text-red-600 mt-2"},se={class:"table table-hover text-nowrap mt-6"},re=e("thead",null,[e("tr",null,[e("th",null,"No"),e("th",null,"Tree Number"),e("th",null,"Quantity (Kgs)"),e("th",null,"Action")])],-1),ne={class:"flex justify-between"},le=["onClick"],ie={class:"flex justify-end mt-4"};function de(r,n,d,ae,t,c){const x=m("Head"),v=m("Datepicker"),w=m("BreezeAuthenticatedLayout");return l(),i(_,null,[f(x,{title:"Operational Planning"}),f(w,null,{default:j(()=>[e("div",I,[L,e("section",M,[e("div",N,[e("div",H,[e("section",U,[e("div",z,[e("div",P,[e("div",R,[e("div",Y,[e("div",T,[F,e("p",null,"Card No: "+o(d.Jobcard.job_card_number),1),e("p",null,"Site: "+o(d.Jobcard.site),1)]),e("div",Z,[d.success?(l(),i("div",E,o(d.success),1)):a("",!0),e("div",K,[e("form",{onSubmit:n[3]||(n[3]=C(s=>c.update(),["prevent"]))},[e("div",Q,[e("label",null,o(r.$page.props.ActivityTitle)+" Start Date:",1),f(v,{modelValue:t.start_date,"onUpdate:modelValue":n[0]||(n[0]=s=>t.start_date=s),position:"left",altPosition:""},null,8,["modelValue"])]),e("div",W,[t.SelectedOne?(l(),i("div",X,[h(e("input",{type:"number",class:"w-full py-1 border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm","onUpdate:modelValue":n[1]||(n[1]=s=>t.form.Goodquantity=s),placeholder:"Good Seed"},null,512),[[g,t.form.Goodquantity]]),h(e("input",{type:"number",class:"w-full py-1 border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm","onUpdate:modelValue":n[2]||(n[2]=s=>t.form.Badquantity=s),placeholder:"Rejected Seed"},null,512),[[g,t.form.Badquantity]]),e("button",{class:D([{"opacity-25":t.form.processing},"inline-flex justify-center rounded-md border border-transparent px-3 py-1 bg-blue-600 text-base leading-6 font-medium text-white shadow-sm hover:bg-blue-500 focus:outline-none focus:border-blue-700 focus:shadow-outline-blue transition ease-in-out duration-150 sm:text-sm sm:leading-5"]),disabled:t.form.processing}," Save ",10,$)])):a("",!0),t.form.errors.Goodquantity?(l(),i("p",ee,o(t.form.errors.Goodquantity),1)):a("",!0),t.form.errors.Badquantity?(l(),i("p",te,o(t.form.errors.Badquantity),1)):a("",!0),t.form.errors.receivedBy?(l(),i("p",oe,o(t.form.errors.receivedBy),1)):a("",!0),e("table",se,[re,e("tbody",null,[(l(!0),i(_,null,y(d.Jobcard.fruits,(s,p)=>(l(),i("tr",{key:p},[e("td",null,o(p+1),1),e("td",null,o(s.tree.tree_number),1),e("td",null,[(l(!0),i(_,null,y(s.stocks,(u,S)=>(l(),i("ol",{key:S},[e("li",ne,[e("p",null,"Good - "+o(u.quantity),1),e("p",null,"Rejected - "+o(u.damage_seed),1),e("p",null,o(c.format_date(u.created_at)),1)])]))),128))]),e("td",null,[e("i",{onClick:u=>c.selected(s.id),class:"fas fa-edit cursor-pointer text-green-500 hover:text-green-800"},null,8,le)])]))),128))])])])],32),e("div",ie,[e("button",{onClick:n[4]||(n[4]=s=>c.complete(d.Jobcard.id)),class:"inline-flex justify-center rounded-md border border-transparent px-4 py-2 bg-green-600 text-base leading-6 font-medium text-white shadow-sm hover:bg-green-500 focus:outline-none focus:border-green-700 focus:shadow-outline-green transition ease-in-out duration-150 sm:text-sm sm:leading-5"}," Sign and Proceed ")])])])])])])])])])])])])]),_:1})],64)}const be=O(A,[["render",de]]);export{be as default};
