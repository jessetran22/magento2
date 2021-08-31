<?php
namespace Magento\AcceptanceTest\_default\Backend;

use Magento\FunctionalTestingFramework\AcceptanceTester;
use \Codeception\Util\Locator;
use Yandex\Allure\Adapter\Annotation\Features;
use Yandex\Allure\Adapter\Annotation\Stories;
use Yandex\Allure\Adapter\Annotation\Title;
use Yandex\Allure\Adapter\Annotation\Description;
use Yandex\Allure\Adapter\Annotation\Parameter;
use Yandex\Allure\Adapter\Annotation\Severity;
use Yandex\Allure\Adapter\Model\SeverityLevel;
use Yandex\Allure\Adapter\Annotation\TestCaseId;

/**
 * @Title("MC-25351: Admin should be able to apply the catalog price rule by product attribute")
 * @Description("Admin should be able to apply the catalog price rule by product attribute<h3>Test files</h3>app/code/Magento/CatalogRule/Test/Mftf/Test/AdminApplyCatalogPriceRuleByProductAttributeTest.xml<br>")
 * @TestCaseId("MC-25351")
 * @group catalogRule
 */
class AdminApplyCatalogPriceRuleByProductAttributeTestCest
{
    /**
     * @var \Magento\FunctionalTestingFramework\Helper\HelperContainer
     */
    private $helperContainer;

    /**
     * Special method which automatically creates the respective objects.
     */
    public function _inject(\Magento\FunctionalTestingFramework\Helper\HelperContainer $helperContainer)
    {
        $this->helperContainer = $helperContainer;
        $this->helperContainer->create("Magento\Catalog\Test\Mftf\Helper\LocalFileAssertions");
        $this->helperContainer->create("\Magento\Catalog\Test\Mftf\Helper\LocalFileAssertions");
        $this->helperContainer->create("\Magento\Backend\Test\Mftf\Helper\CurlHelpers");
        $this->helperContainer->create("Magento\Rule\Test\Mftf\Helper\RuleHelper");
    }
	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _before(AcceptanceTester $I)
	{
		$I->createEntity("createDropdownAttribute", "hook", "productDropDownAttribute", [], []); // stepKey: createDropdownAttribute
		$I->comment("Create attribute options");
		$I->createEntity("createProductAttributeOptionGreen", "hook", "ProductAttributeOption7", ["createDropdownAttribute"], []); // stepKey: createProductAttributeOptionGreen
		$I->createEntity("createProductAttributeOptionRed", "hook", "ProductAttributeOption8", ["createDropdownAttribute"], []); // stepKey: createProductAttributeOptionRed
		$I->comment("Add attribute to default attribute set");
		$I->createEntity("addAttributeToDefaultSet", "hook", "AddToDefaultSet", ["createDropdownAttribute"], []); // stepKey: addAttributeToDefaultSet
		$I->createEntity("createCategory", "hook", "ApiCategory", [], []); // stepKey: createCategory
		$createFirstProductFields['price'] = "40.00";
		$I->createEntity("createFirstProduct", "hook", "ApiSimpleProduct", ["createCategory"], $createFirstProductFields); // stepKey: createFirstProduct
		$createSecondProductFields['price'] = "40.00";
		$I->createEntity("createSecondProduct", "hook", "ApiSimpleProduct", ["createCategory"], $createSecondProductFields); // stepKey: createSecondProduct
		$I->comment("Create the configurable product based on the data in the /data folder");
		$I->createEntity("createConfigProduct", "hook", "ApiConfigurableProduct", ["createCategory"], []); // stepKey: createConfigProduct
		$I->comment("Make the configurable product have two options, that are children of the default attribute set");
		$I->createEntity("createConfigProductAttribute", "hook", "productAttributeWithTwoOptionsNotVisible", [], []); // stepKey: createConfigProductAttribute
		$I->createEntity("createFirstConfigProductAttributeOption", "hook", "productAttributeOption1", ["createConfigProductAttribute"], []); // stepKey: createFirstConfigProductAttributeOption
		$I->createEntity("createSecondConfigProductAttributeOption", "hook", "productAttributeOption2", ["createConfigProductAttribute"], []); // stepKey: createSecondConfigProductAttributeOption
		$I->createEntity("createConfigAddToAttributeSet", "hook", "AddToDefaultSet", ["createConfigProductAttribute"], []); // stepKey: createConfigAddToAttributeSet
		$I->getEntity("getFirstConfigAttributeOption", "hook", "ProductAttributeOptionGetter", ["createConfigProductAttribute"], null, 1); // stepKey: getFirstConfigAttributeOption
		$I->getEntity("getSecondConfigAttributeOption", "hook", "ProductAttributeOptionGetter", ["createConfigProductAttribute"], null, 2); // stepKey: getSecondConfigAttributeOption
		$I->comment("Create the 2 children that will be a part of the configurable product");
		$createConfigFirstChildProductFields['price'] = "60.00";
		$I->createEntity("createConfigFirstChildProduct", "hook", "ApiSimpleOne", ["createConfigProductAttribute", "getFirstConfigAttributeOption"], $createConfigFirstChildProductFields); // stepKey: createConfigFirstChildProduct
		$createConfigSecondChildProductFields['price'] = "60.00";
		$I->createEntity("createConfigSecondChildProduct", "hook", "ApiSimpleTwo", ["createConfigProductAttribute", "getSecondConfigAttributeOption"], $createConfigSecondChildProductFields); // stepKey: createConfigSecondChildProduct
		$I->comment("Assign the two products to the configurable product");
		$I->createEntity("createConfigProductOption", "hook", "ConfigurableProductTwoOptions", ["createConfigProduct", "createConfigProductAttribute", "getFirstConfigAttributeOption", "getSecondConfigAttributeOption"], []); // stepKey: createConfigProductOption
		$I->createEntity("createFirstConfigProductAddChild", "hook", "ConfigurableProductAddChild", ["createConfigProduct", "createConfigFirstChildProduct"], []); // stepKey: createFirstConfigProductAddChild
		$I->createEntity("createSecondConfigProductAddChild", "hook", "ConfigurableProductAddChild", ["createConfigProduct", "createConfigSecondChildProduct"], []); // stepKey: createSecondConfigProductAddChild
		$I->comment("Entering Action Group [loginToAdmin] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginToAdmin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginToAdmin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginToAdmin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginToAdmin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginToAdminWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginToAdmin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginToAdmin
		$I->comment("Exiting Action Group [loginToAdmin] AdminLoginActionGroup");
		$I->comment("Update first simple product");
		$I->comment("Entering Action Group [openFirstSimpleProductForEdit] AdminProductPageOpenByIdActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/edit/id/" . $I->retrieveEntityField('createFirstProduct', 'id', 'hook')); // stepKey: goToProductOpenFirstSimpleProductForEdit
		$I->comment("Exiting Action Group [openFirstSimpleProductForEdit] AdminProductPageOpenByIdActionGroup");
		$I->selectOption("//select[@name='product[" . $I->retrieveEntityField('createDropdownAttribute', 'attribute[attribute_code]', 'hook') . "]']", $I->retrieveEntityField('createProductAttributeOptionGreen', 'option[store_labels][0][label]', 'hook')); // stepKey: setAttributeValueForFirstSimple
		$I->comment("Entering Action Group [saveFirstSimpleProduct] SaveProductFormActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollTopPageProductSaveFirstSimpleProduct
		$I->waitForElementVisible("#save-button", 30); // stepKey: waitForSaveProductButtonSaveFirstSimpleProduct
		$I->waitForPageLoad(30); // stepKey: waitForSaveProductButtonSaveFirstSimpleProductWaitForPageLoad
		$I->click("#save-button"); // stepKey: clickSaveProductSaveFirstSimpleProduct
		$I->waitForPageLoad(30); // stepKey: clickSaveProductSaveFirstSimpleProductWaitForPageLoad
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitProductSaveSuccessMessageSaveFirstSimpleProduct
		$I->dontSee(".message-warning"); // stepKey: dontSeeWarningMessageSaveFirstSimpleProduct
		$I->see("You saved the product.", "#messages div.message-success"); // stepKey: seeSaveConfirmationSaveFirstSimpleProduct
		$I->comment("Exiting Action Group [saveFirstSimpleProduct] SaveProductFormActionGroup");
		$I->comment("Update second simple product");
		$I->comment("Entering Action Group [openSecondSimpleProductForEdit] AdminProductPageOpenByIdActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/edit/id/" . $I->retrieveEntityField('createSecondProduct', 'id', 'hook')); // stepKey: goToProductOpenSecondSimpleProductForEdit
		$I->comment("Exiting Action Group [openSecondSimpleProductForEdit] AdminProductPageOpenByIdActionGroup");
		$I->selectOption("//select[@name='product[" . $I->retrieveEntityField('createDropdownAttribute', 'attribute[attribute_code]', 'hook') . "]']", $I->retrieveEntityField('createProductAttributeOptionRed', 'option[store_labels][0][label]', 'hook')); // stepKey: setAttributeValueForSecondSimple
		$I->comment("Entering Action Group [saveSecondSimpleProduct] SaveProductFormActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollTopPageProductSaveSecondSimpleProduct
		$I->waitForElementVisible("#save-button", 30); // stepKey: waitForSaveProductButtonSaveSecondSimpleProduct
		$I->waitForPageLoad(30); // stepKey: waitForSaveProductButtonSaveSecondSimpleProductWaitForPageLoad
		$I->click("#save-button"); // stepKey: clickSaveProductSaveSecondSimpleProduct
		$I->waitForPageLoad(30); // stepKey: clickSaveProductSaveSecondSimpleProductWaitForPageLoad
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitProductSaveSuccessMessageSaveSecondSimpleProduct
		$I->dontSee(".message-warning"); // stepKey: dontSeeWarningMessageSaveSecondSimpleProduct
		$I->see("You saved the product.", "#messages div.message-success"); // stepKey: seeSaveConfirmationSaveSecondSimpleProduct
		$I->comment("Exiting Action Group [saveSecondSimpleProduct] SaveProductFormActionGroup");
		$I->comment("Update first child of configurable product");
		$I->comment("Entering Action Group [openFirstChildProductForEdit] AdminProductPageOpenByIdActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/edit/id/" . $I->retrieveEntityField('createConfigFirstChildProduct', 'id', 'hook')); // stepKey: goToProductOpenFirstChildProductForEdit
		$I->comment("Exiting Action Group [openFirstChildProductForEdit] AdminProductPageOpenByIdActionGroup");
		$I->selectOption("//select[@name='product[" . $I->retrieveEntityField('createDropdownAttribute', 'attribute[attribute_code]', 'hook') . "]']", $I->retrieveEntityField('createProductAttributeOptionGreen', 'option[store_labels][0][label]', 'hook')); // stepKey: setAttributeValueForFirstChildProduct
		$I->comment("Entering Action Group [saveFirstChildProduct] SaveProductFormActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollTopPageProductSaveFirstChildProduct
		$I->waitForElementVisible("#save-button", 30); // stepKey: waitForSaveProductButtonSaveFirstChildProduct
		$I->waitForPageLoad(30); // stepKey: waitForSaveProductButtonSaveFirstChildProductWaitForPageLoad
		$I->click("#save-button"); // stepKey: clickSaveProductSaveFirstChildProduct
		$I->waitForPageLoad(30); // stepKey: clickSaveProductSaveFirstChildProductWaitForPageLoad
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitProductSaveSuccessMessageSaveFirstChildProduct
		$I->dontSee(".message-warning"); // stepKey: dontSeeWarningMessageSaveFirstChildProduct
		$I->see("You saved the product.", "#messages div.message-success"); // stepKey: seeSaveConfirmationSaveFirstChildProduct
		$I->comment("Exiting Action Group [saveFirstChildProduct] SaveProductFormActionGroup");
		$I->comment("Update second child of configurable product");
		$I->comment("Entering Action Group [openSecondChildProductForEdit] AdminProductPageOpenByIdActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/edit/id/" . $I->retrieveEntityField('createConfigSecondChildProduct', 'id', 'hook')); // stepKey: goToProductOpenSecondChildProductForEdit
		$I->comment("Exiting Action Group [openSecondChildProductForEdit] AdminProductPageOpenByIdActionGroup");
		$I->selectOption("//select[@name='product[" . $I->retrieveEntityField('createDropdownAttribute', 'attribute[attribute_code]', 'hook') . "]']", $I->retrieveEntityField('createProductAttributeOptionGreen', 'option[store_labels][0][label]', 'hook')); // stepKey: setAttributeValueForSecondChildProduct
		$I->comment("Entering Action Group [saveSecondChildProduct] SaveProductFormActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollTopPageProductSaveSecondChildProduct
		$I->waitForElementVisible("#save-button", 30); // stepKey: waitForSaveProductButtonSaveSecondChildProduct
		$I->waitForPageLoad(30); // stepKey: waitForSaveProductButtonSaveSecondChildProductWaitForPageLoad
		$I->click("#save-button"); // stepKey: clickSaveProductSaveSecondChildProduct
		$I->waitForPageLoad(30); // stepKey: clickSaveProductSaveSecondChildProductWaitForPageLoad
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitProductSaveSuccessMessageSaveSecondChildProduct
		$I->dontSee(".message-warning"); // stepKey: dontSeeWarningMessageSaveSecondChildProduct
		$I->see("You saved the product.", "#messages div.message-success"); // stepKey: seeSaveConfirmationSaveSecondChildProduct
		$I->comment("Exiting Action Group [saveSecondChildProduct] SaveProductFormActionGroup");
		$I->comment("Entering Action Group [deleteAllCatalogPriceRule] AdminCatalogPriceRuleDeleteAllActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog_rule/promo_catalog/"); // stepKey: goToAdminCatalogPriceRuleGridPageDeleteAllCatalogPriceRule
		$I->comment("It sometimes is loading too long for default 10s");
		$I->waitForPageLoad(60); // stepKey: waitForPageFullyLoadedDeleteAllCatalogPriceRule
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clearExistingFiltersDeleteAllCatalogPriceRule
		$I->waitForPageLoad(30); // stepKey: clearExistingFiltersDeleteAllCatalogPriceRuleWaitForPageLoad
		$I->comment('[deleteAllRulesOneByOneDeleteAllCatalogPriceRule] Magento\Rule\Test\Mftf\Helper\RuleHelper::deleteAllRulesOneByOne()');
		$this->helperContainer->get('Magento\Rule\Test\Mftf\Helper\RuleHelper')->deleteAllRulesOneByOne("table.data-grid tbody tr[data-role=row]:not(.data-grid-tr-no-data):nth-of-type(1)", "aside.confirm .modal-footer button.action-accept", "#delete", "#messages div.message-success", "You deleted the rule."); // stepKey: deleteAllRulesOneByOneDeleteAllCatalogPriceRule
		$I->waitForElementVisible(".data-grid-tr-no-data td", 30); // stepKey: waitDataGridEmptyMessageAppearsDeleteAllCatalogPriceRule
		$I->see("We couldn't find any records.", ".data-grid-tr-no-data td"); // stepKey: assertDataGridEmptyMessageDeleteAllCatalogPriceRule
		$I->comment("Exiting Action Group [deleteAllCatalogPriceRule] AdminCatalogPriceRuleDeleteAllActionGroup");
		$reindexInvalidatedIndices = $I->magentoCron("index", 90); // stepKey: reindexInvalidatedIndices
		$I->comment($reindexInvalidatedIndices);
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Delete created data");
		$I->deleteEntity("createDropdownAttribute", "hook"); // stepKey: deleteDropdownAttribute
		$I->deleteEntity("createFirstProduct", "hook"); // stepKey: deleteFirstProduct
		$I->deleteEntity("createSecondProduct", "hook"); // stepKey: deleteSecondProduct
		$I->deleteEntity("createCategory", "hook"); // stepKey: deleteCategory
		$I->deleteEntity("createConfigProduct", "hook"); // stepKey: deleteConfigProduct
		$I->deleteEntity("createConfigFirstChildProduct", "hook"); // stepKey: deleteConfigFirstChildProduct
		$I->deleteEntity("createConfigSecondChildProduct", "hook"); // stepKey: deleteConfigSecondChildProduct
		$I->deleteEntity("createConfigProductAttribute", "hook"); // stepKey: deleteConfigProductAttribute
		$I->comment("Entering Action Group [deleteAllCatalogPriceRule] AdminCatalogPriceRuleDeleteAllActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog_rule/promo_catalog/"); // stepKey: goToAdminCatalogPriceRuleGridPageDeleteAllCatalogPriceRule
		$I->comment("It sometimes is loading too long for default 10s");
		$I->waitForPageLoad(60); // stepKey: waitForPageFullyLoadedDeleteAllCatalogPriceRule
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clearExistingFiltersDeleteAllCatalogPriceRule
		$I->waitForPageLoad(30); // stepKey: clearExistingFiltersDeleteAllCatalogPriceRuleWaitForPageLoad
		$I->comment('[deleteAllRulesOneByOneDeleteAllCatalogPriceRule] Magento\Rule\Test\Mftf\Helper\RuleHelper::deleteAllRulesOneByOne()');
		$this->helperContainer->get('Magento\Rule\Test\Mftf\Helper\RuleHelper')->deleteAllRulesOneByOne("table.data-grid tbody tr[data-role=row]:not(.data-grid-tr-no-data):nth-of-type(1)", "aside.confirm .modal-footer button.action-accept", "#delete", "#messages div.message-success", "You deleted the rule."); // stepKey: deleteAllRulesOneByOneDeleteAllCatalogPriceRule
		$I->waitForElementVisible(".data-grid-tr-no-data td", 30); // stepKey: waitDataGridEmptyMessageAppearsDeleteAllCatalogPriceRule
		$I->see("We couldn't find any records.", ".data-grid-tr-no-data td"); // stepKey: assertDataGridEmptyMessageDeleteAllCatalogPriceRule
		$I->comment("Exiting Action Group [deleteAllCatalogPriceRule] AdminCatalogPriceRuleDeleteAllActionGroup");
		$I->comment("Entering Action Group [resetCatalogRulesGridFilter] ClearFiltersAdminDataGridActionGroup");
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clearExistingOrderFiltersResetCatalogRulesGridFilter
		$I->waitForPageLoad(30); // stepKey: clearExistingOrderFiltersResetCatalogRulesGridFilterWaitForPageLoad
		$I->comment("Exiting Action Group [resetCatalogRulesGridFilter] ClearFiltersAdminDataGridActionGroup");
		$I->comment("Entering Action Group [logoutFromAdmin] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageLogoutFromAdmin
		$I->comment("Exiting Action Group [logoutFromAdmin] AdminLogoutActionGroup");
		$I->comment("Reindex invalidated indices after product attribute has been created/deleted");
		$reindexInvalidatedIndices = $I->magentoCron("index", 90); // stepKey: reindexInvalidatedIndices
		$I->comment($reindexInvalidatedIndices);
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _failed(AcceptanceTester $I)
	{
		$I->saveScreenshot(); // stepKey: saveScreenshot
	}

	/**
	 * @Features({"CatalogRule"})
	 * @Stories({"Catalog price rule"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminApplyCatalogPriceRuleByProductAttributeTest(AcceptanceTester $I)
	{
		$I->comment("Create Catalog Price Rule");
		$I->comment("Entering Action Group [startCreatingFirstPriceRule] AdminOpenNewCatalogPriceRuleFormPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog_rule/promo_catalog/new/"); // stepKey: openNewCatalogPriceRulePageStartCreatingFirstPriceRule
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadStartCreatingFirstPriceRule
		$I->comment("Exiting Action Group [startCreatingFirstPriceRule] AdminOpenNewCatalogPriceRuleFormPageActionGroup");
		$I->comment("Entering Action Group [fillMainInfoForFirstPriceRule] AdminCatalogPriceRuleFillMainInfoActionGroup");
		$I->fillField("[name='name']", "CatalogPriceRule" . msq("_defaultCatalogRule")); // stepKey: fillNameFillMainInfoForFirstPriceRule
		$I->fillField("[name='description']", "Catalog Price Rule Description"); // stepKey: fillDescriptionFillMainInfoForFirstPriceRule
		$I->conditionalClick("input[name='is_active']+label", "div.admin__actions-switch input[name='is_active'][value='1']+label", false); // stepKey: fillActiveFillMainInfoForFirstPriceRule
		$I->selectOption("[name='website_ids']", ['Main Website']); // stepKey: selectSpecifiedWebsitesFillMainInfoForFirstPriceRule
		$I->selectOption("[name='customer_group_ids']", ['NOT LOGGED IN']); // stepKey: selectSpecifiedCustomerGroupsFillMainInfoForFirstPriceRule
		$I->fillField("[name='from_date']", ""); // stepKey: fillFromDateFillMainInfoForFirstPriceRule
		$I->fillField("[name='to_date']", ""); // stepKey: fillToDateFillMainInfoForFirstPriceRule
		$I->fillField("[name='sort_order']", ""); // stepKey: fillPriorityFillMainInfoForFirstPriceRule
		$I->comment("Exiting Action Group [fillMainInfoForFirstPriceRule] AdminCatalogPriceRuleFillMainInfoActionGroup");
		$I->comment("Entering Action Group [createCatalogPriceRule] AdminFillCatalogRuleConditionWithSelectAttributeActionGroup");
		$I->conditionalClick("[data-index='block_promo_catalog_edit_tab_conditions']", ".rule-param.rule-param-new-child", false); // stepKey: openConditionsTabCreateCatalogPriceRule
		$I->waitForPageLoad(30); // stepKey: openConditionsTabCreateCatalogPriceRuleWaitForPageLoad
		$I->waitForElementVisible(".rule-param.rule-param-new-child", 30); // stepKey: waitForAddConditionButtonCreateCatalogPriceRule
		$I->waitForPageLoad(30); // stepKey: waitForAddConditionButtonCreateCatalogPriceRuleWaitForPageLoad
		$I->click(".rule-param.rule-param-new-child"); // stepKey: addNewConditionCreateCatalogPriceRule
		$I->waitForPageLoad(30); // stepKey: addNewConditionCreateCatalogPriceRuleWaitForPageLoad
		$I->selectOption("select#conditions__1__new_child", $I->retrieveEntityField('createDropdownAttribute', 'default_frontend_label', 'test')); // stepKey: selectTypeConditionCreateCatalogPriceRule
		$I->waitForPageLoad(30); // stepKey: selectTypeConditionCreateCatalogPriceRuleWaitForPageLoad
		$I->click("//span[@class='rule-param']/a[text()='is']"); // stepKey: clickOnOperatorCreateCatalogPriceRule
		$I->selectOption(".rule-param-edit select[name*='[operator]']", "is"); // stepKey: selectConditionCreateCatalogPriceRule
		$I->comment("In case we are choosing already selected value - select is not closed automatically");
		$I->conditionalClick("//span[@class='rule-param']/a[text()='...']", ".rule-param-edit select[name*='[operator]']", true); // stepKey: closeSelectCreateCatalogPriceRule
		$I->click("//span[@class='rule-param']/a[text()='...']"); // stepKey: clickToChooseOption3CreateCatalogPriceRule
		$I->waitForElementVisible(".rule-param-edit [name*='[value]']", 30); // stepKey: waitForValueInputCreateCatalogPriceRule
		$I->selectOption(".rule-param-edit [name*='[value]']", $I->retrieveEntityField('createProductAttributeOptionGreen', 'option[store_labels][0][label]', 'test')); // stepKey: fillConditionValueCreateCatalogPriceRule
		$I->comment("Exiting Action Group [createCatalogPriceRule] AdminFillCatalogRuleConditionWithSelectAttributeActionGroup");
		$I->comment("Entering Action Group [fillActionsForCatalogPriceRule] AdminCatalogPriceRuleFillActionsActionGroup");
		$I->conditionalClick("[data-index='actions'] .fieldset-wrapper-title", "[data-index='actions'] .admin__fieldset-wrapper-content", false); // stepKey: openActionSectionIfNeededFillActionsForCatalogPriceRule
		$I->scrollTo("[data-index='actions'] .fieldset-wrapper-title"); // stepKey: scrollToActionsFieldsetFillActionsForCatalogPriceRule
		$I->waitForElementVisible("[name='simple_action']", 30); // stepKey: waitActionsFieldsetFullyOpenedFillActionsForCatalogPriceRule
		$I->selectOption("[name='simple_action']", "by_percent"); // stepKey: fillDiscountTypeFillActionsForCatalogPriceRule
		$I->fillField("[name='discount_amount']", "50"); // stepKey: fillDiscountAmountFillActionsForCatalogPriceRule
		$I->selectOption("[name='stop_rules_processing']", "Yes"); // stepKey: fillDiscardSubsequentRulesFillActionsForCatalogPriceRule
		$I->comment("Exiting Action Group [fillActionsForCatalogPriceRule] AdminCatalogPriceRuleFillActionsActionGroup");
		$I->comment("Entering Action Group [saveAndApplyCatalogPriceRule] AdminCatalogPriceRuleSaveAndApplyActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollToTopSaveAndApplyCatalogPriceRule
		$I->waitForElementVisible("#save_and_apply", 30); // stepKey: waitForSaveAndApplyButtonSaveAndApplyCatalogPriceRule
		$I->waitForPageLoad(30); // stepKey: waitForSaveAndApplyButtonSaveAndApplyCatalogPriceRuleWaitForPageLoad
		$I->click("#save_and_apply"); // stepKey: saveAndApplyRuleSaveAndApplyCatalogPriceRule
		$I->waitForPageLoad(30); // stepKey: saveAndApplyRuleSaveAndApplyCatalogPriceRuleWaitForPageLoad
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitForSuccessMessageAppearsSaveAndApplyCatalogPriceRule
		$I->see("You saved the rule.", "#messages div.message-success"); // stepKey: checkSuccessSaveMessageSaveAndApplyCatalogPriceRule
		$I->see("Updated rules applied.", "#messages div.message-success"); // stepKey: checkSuccessAppliedMessageSaveAndApplyCatalogPriceRule
		$I->comment("Exiting Action Group [saveAndApplyCatalogPriceRule] AdminCatalogPriceRuleSaveAndApplyActionGroup");
		$I->comment("Adding the comment to replace CliIndexerReindexActionGroup action group ('indexer:reindex' commands) for preserving Backward Compatibility");
		$I->comment("Open first simple product page on storefront");
		$I->comment("Entering Action Group [openFirstSimpleProductPage] OpenStoreFrontProductPageActionGroup");
		$I->amOnPage("/" . $I->retrieveEntityField('createFirstProduct', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: amOnProductPageOpenFirstSimpleProductPage
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoadOpenFirstSimpleProductPage
		$I->comment("Exiting Action Group [openFirstSimpleProductPage] OpenStoreFrontProductPageActionGroup");
		$I->comment("Verify price for simple product with attribute option green=\$20");
		$I->comment("Entering Action Group [assertFirstSimpleProductPrices] AssertStorefrontProductPricesActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForStorefrontProductPageLoadAssertFirstSimpleProductPrices
		$I->see($I->retrieveEntityField('createFirstProduct', 'price', 'test'), "div.price-box.price-final_price"); // stepKey: productPriceAmountAssertFirstSimpleProductPrices
		$I->see("$20.00", "div.price-box.price-final_price [data-price-type='finalPrice'] .price"); // stepKey: productFinalPriceAmountAssertFirstSimpleProductPrices
		$I->comment("Exiting Action Group [assertFirstSimpleProductPrices] AssertStorefrontProductPricesActionGroup");
		$I->comment("Open the configurable product page on storefront");
		$I->comment("Entering Action Group [openConfigurableProductPage] OpenStoreFrontProductPageActionGroup");
		$I->amOnPage("/" . $I->retrieveEntityField('createConfigProduct', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: amOnProductPageOpenConfigurableProductPage
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoadOpenConfigurableProductPage
		$I->comment("Exiting Action Group [openConfigurableProductPage] OpenStoreFrontProductPageActionGroup");
		$I->comment("Verify price for configurable product with attribute option green=\$30");
		$I->selectOption("//select[contains(concat(' ',normalize-space(@class),' '),' super-attribute-select ')]", "option1"); // stepKey: selectFirstOptionOfConfigProduct
		$I->waitForPageLoad(30); // stepKey: selectFirstOptionOfConfigProductWaitForPageLoad
		$I->comment("Entering Action Group [assertConfigProductWithFirstOptionPrices] AssertStorefrontProductPricesActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForStorefrontProductPageLoadAssertConfigProductWithFirstOptionPrices
		$I->see($I->retrieveEntityField('createConfigFirstChildProduct', 'price', 'test'), "div.price-box.price-final_price"); // stepKey: productPriceAmountAssertConfigProductWithFirstOptionPrices
		$I->see("$30.00", "div.price-box.price-final_price [data-price-type='finalPrice'] .price"); // stepKey: productFinalPriceAmountAssertConfigProductWithFirstOptionPrices
		$I->comment("Exiting Action Group [assertConfigProductWithFirstOptionPrices] AssertStorefrontProductPricesActionGroup");
		$I->comment("Verify price for configurable product with attribute option green=\$30");
		$I->selectOption("//select[contains(concat(' ',normalize-space(@class),' '),' super-attribute-select ')]", "option2"); // stepKey: selectSecondOptionOfConfigProduct
		$I->waitForPageLoad(30); // stepKey: selectSecondOptionOfConfigProductWaitForPageLoad
		$I->comment("Entering Action Group [assertConfigProductWithSecondOptionPrices] AssertStorefrontProductPricesActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForStorefrontProductPageLoadAssertConfigProductWithSecondOptionPrices
		$I->see($I->retrieveEntityField('createConfigSecondChildProduct', 'price', 'test'), "div.price-box.price-final_price"); // stepKey: productPriceAmountAssertConfigProductWithSecondOptionPrices
		$I->see("$30.00", "div.price-box.price-final_price [data-price-type='finalPrice'] .price"); // stepKey: productFinalPriceAmountAssertConfigProductWithSecondOptionPrices
		$I->comment("Exiting Action Group [assertConfigProductWithSecondOptionPrices] AssertStorefrontProductPricesActionGroup");
		$I->comment("Open the second simple product page on storefront");
		$I->comment("Entering Action Group [openSecondSimpleProductPage] OpenStoreFrontProductPageActionGroup");
		$I->amOnPage("/" . $I->retrieveEntityField('createSecondProduct', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: amOnProductPageOpenSecondSimpleProductPage
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoadOpenSecondSimpleProductPage
		$I->comment("Exiting Action Group [openSecondSimpleProductPage] OpenStoreFrontProductPageActionGroup");
		$I->comment("Verify Price for second simple product with specialColor red=\$40");
		$I->comment("Entering Action Group [assertSecondSimpleProductPrices] AssertStorefrontProductPricesActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForStorefrontProductPageLoadAssertSecondSimpleProductPrices
		$I->see($I->retrieveEntityField('createSecondProduct', 'price', 'test'), "div.price-box.price-final_price"); // stepKey: productPriceAmountAssertSecondSimpleProductPrices
		$I->see($I->retrieveEntityField('createSecondProduct', 'price', 'test'), "div.price-box.price-final_price [data-price-type='finalPrice'] .price"); // stepKey: productFinalPriceAmountAssertSecondSimpleProductPrices
		$I->comment("Exiting Action Group [assertSecondSimpleProductPrices] AssertStorefrontProductPricesActionGroup");
	}
}
