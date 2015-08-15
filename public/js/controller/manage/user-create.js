$(document).ready(function() {
    initBtn();
});

function initBtn() {
    //初始化添加技能评估按钮事件
    initSkillAdd();
    //初始化后台绑定的删除技能按钮
    initSkillRemove();
    //初始化表单提交
    initFormSubmit();

    initBangCustomer();
}

