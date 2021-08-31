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
 * @Title("MC-27707: Apply catalog price rule for configurable product with options")
 * @Description("Admin should be able to apply the catalog rule for configurable product with options<h3>Test files</h3>app/code/Magento/CatalogRuleConfigurable/Test/Mftf/Test/AdminApplyCatalogRuleForConfigurableProductWithOptions2Test.xml<br>")
 * @TestCaseId("MC-27707")
 * @group catalog
 * @group configurable_product
 * @group catalog_rule_configurable
 * @group mtf_migrated
 */
class AdminApplyCatalogRuleForConfigurableProductWithOptions2TestCest
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
		$I->comment("Create category");
		$I->createEntity("simpleCategory", "hook", "SimpleSubCategory", [], []); // stepKey: simpleCategory
		$I->comment("Create configurable product with three options");
		$I->createEntity("createConfigProduct", "hook", "ApiConfigurableProduct", ["simpleCategory"], []); // stepKey: createConfigProduct
		$I->createEntity("createConfigProductAttribute", "hook", "productAttributeWithTwoOptions", [], []); // stepKey: createConfigProductAttribute
		$I->createEntity("createConfigProductAttributeFirstOption", "hook", "productAttributeOption1", ["createConfigProductAttribute"], []); // stepKey: createConfigProductAttributeFirstOption
		$I->createEntity("createConfigProductAttributeSecondOption", "hook", "productAttributeOption2", ["createConfigProductAttribute"], []); // stepKey: createConfigProductAttributeSecondOption
		$I->createEntity("createConfigProductAttributeThirdOption", "hook", "productAttributeOption3", ["createConfigProductAttribute"], []); // stepKey: createConfigProductAttributeThirdOption
		$I->createEntity("createConfigAddToAttributeSet", "hook", "AddToDefaultSet", ["createConfigProductAttribute"], []); // stepKey: createConfigAddToAttributeSet
		$I->getEntity("getConfigAttributeFirstOption", "hook", "ProductAttributeOptionGetter", ["createConfigProductAttribute"], null, 1); // stepKey: getConfigAttributeFirstOption
		$I->getEntity("getConfigAttributeSecondOption", "hook", "ProductAttributeOptionGetter", ["createConfigProductAttribute"], null, 2); // stepKey: getConfigAttributeSecondOption
		$I->getEntity("getConfigAttributeThirdOption", "hook", "ProductAttributeOptionGetter", ["createConfigProductAttribute"], null, 3); // stepKey: getConfigAttributeThirdOption
		$I->comment("Create three child products");
		$I->createEntity("createConfigFirstChildProduct", "hook", "ApiSimpleOne", ["createConfigProductAttribute", "getConfigAttributeFirstOption"], []); // stepKey: createConfigFirstChildProduct
		$I->createEntity("createConfigSecondChildProduct", "hook", "ApiSimpleOne", ["createConfigProductAttribute", "getConfigAttributeSecondOption"], []); // stepKey: createConfigSecondChildProduct
		$I->createEntity("createConfigThirdChildProduct", "hook", "ApiSimpleOne", ["createConfigProductAttribute", "getConfigAttributeThirdOption"], []); // stepKey: createConfigThirdChildProduct
		$I->createEntity("createConfigProductOption", "hook", "ConfigurableProductTwoOptions", ["createConfigProduct", "createConfigProductAttribute", "getConfigAttributeFirstOption", "getConfigAttributeSecondOption", "getConfigAttributeThirdOption"], []); // stepKey: createConfigProductOption
		$I->createEntity("createConfigProductAddFirstChild", "hook", "ConfigurableProductAddChild", ["createConfigProduct", "createConfigFirstChildProduct"], []); // stepKey: createConfigProductAddFirstChild
		$I->createEntity("createConfigProductAddSecondChild", "hook", "ConfigurableProductAddChild", ["createConfigProduct", "createConfigSecondChildProduct"], []); // stepKey: createConfigProductAddSecondChild
		$I->createEntity("createConfigProductAddThirdChild", "hook", "ConfigurableProductAddChild", ["createConfigProduct", "createConfigThirdChildProduct"], []); // stepKey: createConfigProductAddThirdChild
		$I->comment("Login as Admin");
		$I->comment("Entering Action Group [loginToAdminPanel] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginToAdminPanel
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginToAdminPanel
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginToAdminPanel
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginToAdminPanel
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginToAdminPanelWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginToAdminPanel
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginToAdminPanel
		$I->comment("Exiting Action Group [loginToAdminPanel] AdminLoginActionGroup");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Delete created data");
		$I->deleteEntity("createConfigProduct", "hook"); // stepKey: deleteConfigProduct
		$I->deleteEntity("createConfigFirstChildProduct", "hook"); // stepKey: deleteFirstSimpleProduct
		$I->deleteEntity("createConfigSecondChildProduct", "hook"); // stepKey: deleteSecondSimpleProduct
		$I->deleteEntity("createConfigThirdChildProduct", "hook"); // stepKey: deleteThirdSimpleProduct
		$I->deleteEntity("createConfigProductAttribute", "hook"); // stepKey: deleteConfigProductAttribute
		$I->deleteEntity("simpleCategory", "hook"); // stepKey: deleteCategory
		$I->comment("Delete created price rules");
		$I->comment("Entering Action Group [deleteFirstCatalogPriceRule] RemoveCatalogPriceRuleActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog_rule/promo_catalog/"); // stepKey: goToAdminCatalogPriceRuleGridPageDeleteFirstCatalogPriceRule
		$I->waitForPageLoad(30); // stepKey: waitForAdminCatalogPriceRuleGridPageLoadDeleteFirstCatalogPriceRule
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clearExistingFiltersDeleteFirstCatalogPriceRule
		$I->waitForPageLoad(30); // stepKey: clearExistingFiltersDeleteFirstCatalogPriceRuleWaitForPageLoad
		$I->fillField("#promo_catalog_grid_filter_name", "CatalogPriceRule" . msq("CatalogRuleToFixed")); // stepKey: filterByRuleNameDeleteFirstCatalogPriceRule
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickSearchDeleteFirstCatalogPriceRule
		$I->waitForPageLoad(30); // stepKey: clickSearchDeleteFirstCatalogPriceRuleWaitForPageLoad
		$I->click("table.data-grid tbody tr[data-role=row]:nth-of-type(1)"); // stepKey: clickEditDeleteFirstCatalogPriceRule
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadDeleteFirstCatalogPriceRule
		$I->click("#delete"); // stepKey: clickToDeleteDeleteFirstCatalogPriceRule
		$I->waitForPageLoad(30); // stepKey: clickToDeleteDeleteFirstCatalogPriceRuleWaitForPageLoad
		$I->waitForElementVisible("aside.confirm .modal-footer button.action-accept", 30); // stepKey: waitForElementVisibleDeleteFirstCatalogPriceRule
		$I->waitForPageLoad(60); // stepKey: waitForElementVisibleDeleteFirstCatalogPriceRuleWaitForPageLoad
		$I->click("aside.confirm .modal-footer button.action-accept"); // stepKey: clickToConfirmDeleteFirstCatalogPriceRule
		$I->waitForPageLoad(60); // stepKey: clickToConfirmDeleteFirstCatalogPriceRuleWaitForPageLoad
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitForSuccessMessageDeleteFirstCatalogPriceRule
		$I->see("You deleted the rule.", "#messages div.message-success"); // stepKey: verifyRuleIsDeletedDeleteFirstCatalogPriceRule
		$I->comment("Exiting Action Group [deleteFirstCatalogPriceRule] RemoveCatalogPriceRuleActionGroup");
		$I->comment("Entering Action Group [deleteSecondCatalogPriceRule] RemoveCatalogPriceRuleActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog_rule/promo_catalog/"); // stepKey: goToAdminCatalogPriceRuleGridPageDeleteSecondCatalogPriceRule
		$I->waitForPageLoad(30); // stepKey: waitForAdminCatalogPriceRuleGridPageLoadDeleteSecondCatalogPriceRule
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clearExistingFiltersDeleteSecondCatalogPriceRule
		$I->waitForPageLoad(30); // stepKey: clearExistingFiltersDeleteSecondCatalogPriceRuleWaitForPageLoad
		$I->fillField("#promo_catalog_grid_filter_name", "CatalogPriceRuleWithoutDiscount" . msq("CatalogRuleWithoutDiscount")); // stepKey: filterByRuleNameDeleteSecondCatalogPriceRule
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickSearchDeleteSecondCatalogPriceRule
		$I->waitForPageLoad(30); // stepKey: clickSearchDeleteSecondCatalogPriceRuleWaitForPageLoad
		$I->click("table.data-grid tbody tr[data-role=row]:nth-of-type(1)"); // stepKey: clickEditDeleteSecondCatalogPriceRule
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadDeleteSecondCatalogPriceRule
		$I->click("#delete"); // stepKey: clickToDeleteDeleteSecondCatalogPriceRule
		$I->waitForPageLoad(30); // stepKey: clickToDeleteDeleteSecondCatalogPriceRuleWaitForPageLoad
		$I->waitForElementVisible("aside.confirm .modal-footer button.action-accept", 30); // stepKey: waitForElementVisibleDeleteSecondCatalogPriceRule
		$I->waitForPageLoad(60); // stepKey: waitForElementVisibleDeleteSecondCatalogPriceRuleWaitForPageLoad
		$I->click("aside.confirm .modal-footer button.action-accept"); // stepKey: clickToConfirmDeleteSecondCatalogPriceRule
		$I->waitForPageLoad(60); // stepKey: clickToConfirmDeleteSecondCatalogPriceRuleWaitForPageLoad
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitForSuccessMessageDeleteSecondCatalogPriceRule
		$I->see("You deleted the rule.", "#messages div.message-success"); // stepKey: verifyRuleIsDeletedDeleteSecondCatalogPriceRule
		$I->comment("Exiting Action Group [deleteSecondCatalogPriceRule] RemoveCatalogPriceRuleActionGroup");
		$I->comment("Entering Action Group [deleteThirdCatalogPriceRule] RemoveCatalogPriceRuleActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog_rule/promo_catalog/"); // stepKey: goToAdminCatalogPriceRuleGridPageDeleteThirdCatalogPriceRule
		$I->waitForPageLoad(30); // stepKey: waitForAdminCatalogPriceRuleGridPageLoadDeleteThirdCatalogPriceRule
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clearExistingFiltersDeleteThirdCatalogPriceRule
		$I->waitForPageLoad(30); // stepKey: clearExistingFiltersDeleteThirdCatalogPriceRuleWaitForPageLoad
		$I->fillField("#promo_catalog_grid_filter_name", "CatalogPriceRule" . msq("_defaultCatalogRule")); // stepKey: filterByRuleNameDeleteThirdCatalogPriceRule
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickSearchDeleteThirdCatalogPriceRule
		$I->waitForPageLoad(30); // stepKey: clickSearchDeleteThirdCatalogPriceRuleWaitForPageLoad
		$I->click("table.data-grid tbody tr[data-role=row]:nth-of-type(1)"); // stepKey: clickEditDeleteThirdCatalogPriceRule
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadDeleteThirdCatalogPriceRule
		$I->click("#delete"); // stepKey: clickToDeleteDeleteThirdCatalogPriceRule
		$I->waitForPageLoad(30); // stepKey: clickToDeleteDeleteThirdCatalogPriceRuleWaitForPageLoad
		$I->waitForElementVisible("aside.confirm .modal-footer button.action-accept", 30); // stepKey: waitForElementVisibleDeleteThirdCatalogPriceRule
		$I->waitForPageLoad(60); // stepKey: waitForElementVisibleDeleteThirdCatalogPriceRuleWaitForPageLoad
		$I->click("aside.confirm .modal-footer button.action-accept"); // stepKey: clickToConfirmDeleteThirdCatalogPriceRule
		$I->waitForPageLoad(60); // stepKey: clickToConfirmDeleteThirdCatalogPriceRuleWaitForPageLoad
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitForSuccessMessageDeleteThirdCatalogPriceRule
		$I->see("You deleted the rule.", "#messages div.message-success"); // stepKey: verifyRuleIsDeletedDeleteThirdCatalogPriceRule
		$I->comment("Exiting Action Group [deleteThirdCatalogPriceRule] RemoveCatalogPriceRuleActionGroup");
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
	 * @Features({"CatalogRuleConfigurable"})
	 * @Stories({"Apply catalog price rule"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminApplyCatalogRuleForConfigurableProductWithOptions2Test(AcceptanceTester $I)
	{
		$I->comment("Create price rule for first configurable product option");
		$I->comment("Entering Action Group [startCreatingFirstPriceRule] AdminOpenNewCatalogPriceRuleFormPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog_rule/promo_catalog/new/"); // stepKey: openNewCatalogPriceRulePageStartCreatingFirstPriceRule
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadStartCreatingFirstPriceRule
		$I->comment("Exiting Action Group [startCreatingFirstPriceRule] AdminOpenNewCatalogPriceRuleFormPageActionGroup");
		$I->comment("Entering Action Group [fillMainInfoForFirstPriceRule] AdminCatalogPriceRuleFillMainInfoActionGroup");
		$I->fillField("[name='name']", "CatalogPriceRule" . msq("CatalogRuleToFixed")); // stepKey: fillNameFillMainInfoForFirstPriceRule
		$I->fillField("[name='description']", "Catalog Price Rule Description"); // stepKey: fillDescriptionFillMainInfoForFirstPriceRule
		$I->conditionalClick("input[name='is_active']+label", "div.admin__actions-switch input[name='is_active'][value='1']+label", false); // stepKey: fillActiveFillMainInfoForFirstPriceRule
		$I->selectOption("[name='website_ids']", ['Main Website']); // stepKey: selectSpecifiedWebsitesFillMainInfoForFirstPriceRule
		$I->selectOption("[name='customer_group_ids']", ['NOT LOGGED IN']); // stepKey: selectSpecifiedCustomerGroupsFillMainInfoForFirstPriceRule
		$I->fillField("[name='from_date']", ""); // stepKey: fillFromDateFillMainInfoForFirstPriceRule
		$I->fillField("[name='to_date']", ""); // stepKey: fillToDateFillMainInfoForFirstPriceRule
		$I->fillField("[name='sort_order']", ""); // stepKey: fillPriorityFillMainInfoForFirstPriceRule
		$I->comment("Exiting Action Group [fillMainInfoForFirstPriceRule] AdminCatalogPriceRuleFillMainInfoActionGroup");
		$I->comment("Entering Action Group [fillConditionsForFirstPriceRule] CreateCatalogPriceRuleConditionWithAttributeAndOptionActionGroup");
		$I->conditionalClick("[data-index='block_promo_catalog_edit_tab_conditions'] .fieldset-wrapper-title", "[data-index='block_promo_catalog_edit_tab_conditions'] .admin__fieldset-wrapper-content", false); // stepKey: openConditionsTabFillConditionsForFirstPriceRule
		$I->waitForPageLoad(30); // stepKey: waitForConditionTabOpenedFillConditionsForFirstPriceRule
		$I->click(".rule-param.rule-param-new-child"); // stepKey: addNewConditionFillConditionsForFirstPriceRule
		$I->waitForPageLoad(30); // stepKey: addNewConditionFillConditionsForFirstPriceRuleWaitForPageLoad
		$I->selectOption("select#conditions__1__new_child", $I->retrieveEntityField('createConfigProductAttribute', 'attribute[frontend_labels][0][label]', 'test')); // stepKey: selectTypeConditionFillConditionsForFirstPriceRule
		$I->waitForPageLoad(30); // stepKey: selectTypeConditionFillConditionsForFirstPriceRuleWaitForPageLoad
		$I->waitForElement("//ul[@id='conditions__1__children']//a[contains(text(), '...')]", 30); // stepKey: waitForTargetFillConditionsForFirstPriceRule
		$I->waitForPageLoad(30); // stepKey: waitForTargetFillConditionsForFirstPriceRuleWaitForPageLoad
		$I->click("//ul[@id='conditions__1__children']//a[contains(text(), '...')]"); // stepKey: clickOnEllipsisFillConditionsForFirstPriceRule
		$I->waitForPageLoad(30); // stepKey: clickOnEllipsisFillConditionsForFirstPriceRuleWaitForPageLoad
		$I->selectOption("select#conditions__1--1__value", $I->retrieveEntityField('createConfigProductAttributeFirstOption', 'option[store_labels][1][label]', 'test')); // stepKey: selectOptionFillConditionsForFirstPriceRule
		$I->waitForPageLoad(30); // stepKey: selectOptionFillConditionsForFirstPriceRuleWaitForPageLoad
		$I->comment("Exiting Action Group [fillConditionsForFirstPriceRule] CreateCatalogPriceRuleConditionWithAttributeAndOptionActionGroup");
		$I->comment("Entering Action Group [fillActionsForFirstPriceRule] AdminCatalogPriceRuleFillActionsActionGroup");
		$I->conditionalClick("[data-index='actions'] .fieldset-wrapper-title", "[data-index='actions'] .admin__fieldset-wrapper-content", false); // stepKey: openActionSectionIfNeededFillActionsForFirstPriceRule
		$I->scrollTo("[data-index='actions'] .fieldset-wrapper-title"); // stepKey: scrollToActionsFieldsetFillActionsForFirstPriceRule
		$I->waitForElementVisible("[name='simple_action']", 30); // stepKey: waitActionsFieldsetFullyOpenedFillActionsForFirstPriceRule
		$I->selectOption("[name='simple_action']", "to_fixed"); // stepKey: fillDiscountTypeFillActionsForFirstPriceRule
		$I->fillField("[name='discount_amount']", "110.7"); // stepKey: fillDiscountAmountFillActionsForFirstPriceRule
		$I->selectOption("[name='stop_rules_processing']", "Yes"); // stepKey: fillDiscardSubsequentRulesFillActionsForFirstPriceRule
		$I->comment("Exiting Action Group [fillActionsForFirstPriceRule] AdminCatalogPriceRuleFillActionsActionGroup");
		$I->comment("Entering Action Group [saveAndApplyFirstPriceRule] AdminCatalogPriceRuleSaveAndApplyActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollToTopSaveAndApplyFirstPriceRule
		$I->waitForElementVisible("#save_and_apply", 30); // stepKey: waitForSaveAndApplyButtonSaveAndApplyFirstPriceRule
		$I->waitForPageLoad(30); // stepKey: waitForSaveAndApplyButtonSaveAndApplyFirstPriceRuleWaitForPageLoad
		$I->click("#save_and_apply"); // stepKey: saveAndApplyRuleSaveAndApplyFirstPriceRule
		$I->waitForPageLoad(30); // stepKey: saveAndApplyRuleSaveAndApplyFirstPriceRuleWaitForPageLoad
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitForSuccessMessageAppearsSaveAndApplyFirstPriceRule
		$I->see("You saved the rule.", "#messages div.message-success"); // stepKey: checkSuccessSaveMessageSaveAndApplyFirstPriceRule
		$I->see("Updated rules applied.", "#messages div.message-success"); // stepKey: checkSuccessAppliedMessageSaveAndApplyFirstPriceRule
		$I->comment("Exiting Action Group [saveAndApplyFirstPriceRule] AdminCatalogPriceRuleSaveAndApplyActionGroup");
		$I->comment("Create price rule for second configurable product option");
		$I->comment("Entering Action Group [startCreatingThirdPriceRule] AdminOpenNewCatalogPriceRuleFormPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog_rule/promo_catalog/new/"); // stepKey: openNewCatalogPriceRulePageStartCreatingThirdPriceRule
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadStartCreatingThirdPriceRule
		$I->comment("Exiting Action Group [startCreatingThirdPriceRule] AdminOpenNewCatalogPriceRuleFormPageActionGroup");
		$I->comment("Entering Action Group [fillMainInfoForThirdPriceRule] AdminCatalogPriceRuleFillMainInfoActionGroup");
		$I->fillField("[name='name']", "CatalogPriceRule" . msq("_defaultCatalogRule")); // stepKey: fillNameFillMainInfoForThirdPriceRule
		$I->fillField("[name='description']", "Catalog Price Rule Description"); // stepKey: fillDescriptionFillMainInfoForThirdPriceRule
		$I->conditionalClick("input[name='is_active']+label", "div.admin__actions-switch input[name='is_active'][value='1']+label", false); // stepKey: fillActiveFillMainInfoForThirdPriceRule
		$I->selectOption("[name='website_ids']", ['Main Website']); // stepKey: selectSpecifiedWebsitesFillMainInfoForThirdPriceRule
		$I->selectOption("[name='customer_group_ids']", ['NOT LOGGED IN']); // stepKey: selectSpecifiedCustomerGroupsFillMainInfoForThirdPriceRule
		$I->fillField("[name='from_date']", ""); // stepKey: fillFromDateFillMainInfoForThirdPriceRule
		$I->fillField("[name='to_date']", ""); // stepKey: fillToDateFillMainInfoForThirdPriceRule
		$I->fillField("[name='sort_order']", ""); // stepKey: fillPriorityFillMainInfoForThirdPriceRule
		$I->comment("Exiting Action Group [fillMainInfoForThirdPriceRule] AdminCatalogPriceRuleFillMainInfoActionGroup");
		$I->comment("Entering Action Group [fillConditionsForThirdPriceRule] CreateCatalogPriceRuleConditionWithAttributeAndOptionActionGroup");
		$I->conditionalClick("[data-index='block_promo_catalog_edit_tab_conditions'] .fieldset-wrapper-title", "[data-index='block_promo_catalog_edit_tab_conditions'] .admin__fieldset-wrapper-content", false); // stepKey: openConditionsTabFillConditionsForThirdPriceRule
		$I->waitForPageLoad(30); // stepKey: waitForConditionTabOpenedFillConditionsForThirdPriceRule
		$I->click(".rule-param.rule-param-new-child"); // stepKey: addNewConditionFillConditionsForThirdPriceRule
		$I->waitForPageLoad(30); // stepKey: addNewConditionFillConditionsForThirdPriceRuleWaitForPageLoad
		$I->selectOption("select#conditions__1__new_child", $I->retrieveEntityField('createConfigProductAttribute', 'attribute[frontend_labels][0][label]', 'test')); // stepKey: selectTypeConditionFillConditionsForThirdPriceRule
		$I->waitForPageLoad(30); // stepKey: selectTypeConditionFillConditionsForThirdPriceRuleWaitForPageLoad
		$I->waitForElement("//ul[@id='conditions__1__children']//a[contains(text(), '...')]", 30); // stepKey: waitForTargetFillConditionsForThirdPriceRule
		$I->waitForPageLoad(30); // stepKey: waitForTargetFillConditionsForThirdPriceRuleWaitForPageLoad
		$I->click("//ul[@id='conditions__1__children']//a[contains(text(), '...')]"); // stepKey: clickOnEllipsisFillConditionsForThirdPriceRule
		$I->waitForPageLoad(30); // stepKey: clickOnEllipsisFillConditionsForThirdPriceRuleWaitForPageLoad
		$I->selectOption("select#conditions__1--1__value", $I->retrieveEntityField('createConfigProductAttributeSecondOption', 'option[store_labels][1][label]', 'test')); // stepKey: selectOptionFillConditionsForThirdPriceRule
		$I->waitForPageLoad(30); // stepKey: selectOptionFillConditionsForThirdPriceRuleWaitForPageLoad
		$I->comment("Exiting Action Group [fillConditionsForThirdPriceRule] CreateCatalogPriceRuleConditionWithAttributeAndOptionActionGroup");
		$I->comment("Entering Action Group [fillActionsForThirdPriceRule] AdminCatalogPriceRuleFillActionsActionGroup");
		$I->conditionalClick("[data-index='actions'] .fieldset-wrapper-title", "[data-index='actions'] .admin__fieldset-wrapper-content", false); // stepKey: openActionSectionIfNeededFillActionsForThirdPriceRule
		$I->scrollTo("[data-index='actions'] .fieldset-wrapper-title"); // stepKey: scrollToActionsFieldsetFillActionsForThirdPriceRule
		$I->waitForElementVisible("[name='simple_action']", 30); // stepKey: waitActionsFieldsetFullyOpenedFillActionsForThirdPriceRule
		$I->selectOption("[name='simple_action']", "by_percent"); // stepKey: fillDiscountTypeFillActionsForThirdPriceRule
		$I->fillField("[name='discount_amount']", "10"); // stepKey: fillDiscountAmountFillActionsForThirdPriceRule
		$I->selectOption("[name='stop_rules_processing']", "Yes"); // stepKey: fillDiscardSubsequentRulesFillActionsForThirdPriceRule
		$I->comment("Exiting Action Group [fillActionsForThirdPriceRule] AdminCatalogPriceRuleFillActionsActionGroup");
		$I->comment("Entering Action Group [saveAndApplyThirdPriceRule] AdminCatalogPriceRuleSaveAndApplyActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollToTopSaveAndApplyThirdPriceRule
		$I->waitForElementVisible("#save_and_apply", 30); // stepKey: waitForSaveAndApplyButtonSaveAndApplyThirdPriceRule
		$I->waitForPageLoad(30); // stepKey: waitForSaveAndApplyButtonSaveAndApplyThirdPriceRuleWaitForPageLoad
		$I->click("#save_and_apply"); // stepKey: saveAndApplyRuleSaveAndApplyThirdPriceRule
		$I->waitForPageLoad(30); // stepKey: saveAndApplyRuleSaveAndApplyThirdPriceRuleWaitForPageLoad
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitForSuccessMessageAppearsSaveAndApplyThirdPriceRule
		$I->see("You saved the rule.", "#messages div.message-success"); // stepKey: checkSuccessSaveMessageSaveAndApplyThirdPriceRule
		$I->see("Updated rules applied.", "#messages div.message-success"); // stepKey: checkSuccessAppliedMessageSaveAndApplyThirdPriceRule
		$I->comment("Exiting Action Group [saveAndApplyThirdPriceRule] AdminCatalogPriceRuleSaveAndApplyActionGroup");
		$I->comment("Create price rule for third configurable product option");
		$I->comment("Entering Action Group [startCreatingSecondPriceRule] AdminOpenNewCatalogPriceRuleFormPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog_rule/promo_catalog/new/"); // stepKey: openNewCatalogPriceRulePageStartCreatingSecondPriceRule
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadStartCreatingSecondPriceRule
		$I->comment("Exiting Action Group [startCreatingSecondPriceRule] AdminOpenNewCatalogPriceRuleFormPageActionGroup");
		$I->comment("Entering Action Group [fillMainInfoForSecondPriceRule] AdminCatalogPriceRuleFillMainInfoActionGroup");
		$I->fillField("[name='name']", "CatalogPriceRuleWithoutDiscount" . msq("CatalogRuleWithoutDiscount")); // stepKey: fillNameFillMainInfoForSecondPriceRule
		$I->fillField("[name='description']", "Catalog Price Rule Description"); // stepKey: fillDescriptionFillMainInfoForSecondPriceRule
		$I->conditionalClick("input[name='is_active']+label", "div.admin__actions-switch input[name='is_active'][value='1']+label", false); // stepKey: fillActiveFillMainInfoForSecondPriceRule
		$I->selectOption("[name='website_ids']", ['Main Website']); // stepKey: selectSpecifiedWebsitesFillMainInfoForSecondPriceRule
		$I->selectOption("[name='customer_group_ids']", ['NOT LOGGED IN']); // stepKey: selectSpecifiedCustomerGroupsFillMainInfoForSecondPriceRule
		$I->fillField("[name='from_date']", ""); // stepKey: fillFromDateFillMainInfoForSecondPriceRule
		$I->fillField("[name='to_date']", ""); // stepKey: fillToDateFillMainInfoForSecondPriceRule
		$I->fillField("[name='sort_order']", ""); // stepKey: fillPriorityFillMainInfoForSecondPriceRule
		$I->comment("Exiting Action Group [fillMainInfoForSecondPriceRule] AdminCatalogPriceRuleFillMainInfoActionGroup");
		$I->comment("Entering Action Group [fillConditionsForSecondPriceRule] CreateCatalogPriceRuleConditionWithAttributeAndOptionActionGroup");
		$I->conditionalClick("[data-index='block_promo_catalog_edit_tab_conditions'] .fieldset-wrapper-title", "[data-index='block_promo_catalog_edit_tab_conditions'] .admin__fieldset-wrapper-content", false); // stepKey: openConditionsTabFillConditionsForSecondPriceRule
		$I->waitForPageLoad(30); // stepKey: waitForConditionTabOpenedFillConditionsForSecondPriceRule
		$I->click(".rule-param.rule-param-new-child"); // stepKey: addNewConditionFillConditionsForSecondPriceRule
		$I->waitForPageLoad(30); // stepKey: addNewConditionFillConditionsForSecondPriceRuleWaitForPageLoad
		$I->selectOption("select#conditions__1__new_child", $I->retrieveEntityField('createConfigProductAttribute', 'attribute[frontend_labels][0][label]', 'test')); // stepKey: selectTypeConditionFillConditionsForSecondPriceRule
		$I->waitForPageLoad(30); // stepKey: selectTypeConditionFillConditionsForSecondPriceRuleWaitForPageLoad
		$I->waitForElement("//ul[@id='conditions__1__children']//a[contains(text(), '...')]", 30); // stepKey: waitForTargetFillConditionsForSecondPriceRule
		$I->waitForPageLoad(30); // stepKey: waitForTargetFillConditionsForSecondPriceRuleWaitForPageLoad
		$I->click("//ul[@id='conditions__1__children']//a[contains(text(), '...')]"); // stepKey: clickOnEllipsisFillConditionsForSecondPriceRule
		$I->waitForPageLoad(30); // stepKey: clickOnEllipsisFillConditionsForSecondPriceRuleWaitForPageLoad
		$I->selectOption("select#conditions__1--1__value", $I->retrieveEntityField('createConfigProductAttributeThirdOption', 'option[store_labels][1][label]', 'test')); // stepKey: selectOptionFillConditionsForSecondPriceRule
		$I->waitForPageLoad(30); // stepKey: selectOptionFillConditionsForSecondPriceRuleWaitForPageLoad
		$I->comment("Exiting Action Group [fillConditionsForSecondPriceRule] CreateCatalogPriceRuleConditionWithAttributeAndOptionActionGroup");
		$I->comment("Entering Action Group [fillActionsForSecondPriceRule] AdminCatalogPriceRuleFillActionsActionGroup");
		$I->conditionalClick("[data-index='actions'] .fieldset-wrapper-title", "[data-index='actions'] .admin__fieldset-wrapper-content", false); // stepKey: openActionSectionIfNeededFillActionsForSecondPriceRule
		$I->scrollTo("[data-index='actions'] .fieldset-wrapper-title"); // stepKey: scrollToActionsFieldsetFillActionsForSecondPriceRule
		$I->waitForElementVisible("[name='simple_action']", 30); // stepKey: waitActionsFieldsetFullyOpenedFillActionsForSecondPriceRule
		$I->selectOption("[name='simple_action']", "by_percent"); // stepKey: fillDiscountTypeFillActionsForSecondPriceRule
		$I->fillField("[name='discount_amount']", "0"); // stepKey: fillDiscountAmountFillActionsForSecondPriceRule
		$I->selectOption("[name='stop_rules_processing']", "Yes"); // stepKey: fillDiscardSubsequentRulesFillActionsForSecondPriceRule
		$I->comment("Exiting Action Group [fillActionsForSecondPriceRule] AdminCatalogPriceRuleFillActionsActionGroup");
		$I->comment("Entering Action Group [saveAndApplySecondPriceRule] AdminCatalogPriceRuleSaveAndApplyActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollToTopSaveAndApplySecondPriceRule
		$I->waitForElementVisible("#save_and_apply", 30); // stepKey: waitForSaveAndApplyButtonSaveAndApplySecondPriceRule
		$I->waitForPageLoad(30); // stepKey: waitForSaveAndApplyButtonSaveAndApplySecondPriceRuleWaitForPageLoad
		$I->click("#save_and_apply"); // stepKey: saveAndApplyRuleSaveAndApplySecondPriceRule
		$I->waitForPageLoad(30); // stepKey: saveAndApplyRuleSaveAndApplySecondPriceRuleWaitForPageLoad
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitForSuccessMessageAppearsSaveAndApplySecondPriceRule
		$I->see("You saved the rule.", "#messages div.message-success"); // stepKey: checkSuccessSaveMessageSaveAndApplySecondPriceRule
		$I->see("Updated rules applied.", "#messages div.message-success"); // stepKey: checkSuccessAppliedMessageSaveAndApplySecondPriceRule
		$I->comment("Exiting Action Group [saveAndApplySecondPriceRule] AdminCatalogPriceRuleSaveAndApplyActionGroup");
		$I->comment("Adding the comment to replace AdminReindexAndFlushCache action group ('indexer:reindex', 'cache:flush' commands) for preserving Backward Compatibility");
		$I->comment("Assert product in storefront product page");
		$I->amOnPage("/" . $I->retrieveEntityField('createConfigProduct', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: amOnProductPage
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoad
		$I->comment("Entering Action Group [assertUpdatedProductPriceInStorefrontProductPage] StorefrontAssertUpdatedProductPriceInStorefrontProductPageActionGroup");
		$I->seeInTitle($I->retrieveEntityField('createConfigProduct', 'name', 'test')); // stepKey: assertProductNameTitleAssertUpdatedProductPriceInStorefrontProductPage
		$I->see($I->retrieveEntityField('createConfigProduct', 'name', 'test'), ".base"); // stepKey: assertProductNameAssertUpdatedProductPriceInStorefrontProductPage
		$I->see("As low as $110.7", "div.price-box.price-final_price"); // stepKey: assertProductPriceAssertUpdatedProductPriceInStorefrontProductPage
		$I->comment("Exiting Action Group [assertUpdatedProductPriceInStorefrontProductPage] StorefrontAssertUpdatedProductPriceInStorefrontProductPageActionGroup");
		$firstOptionPrice = $I->executeJS("return '$' + (110.7).toFixed(2);"); // stepKey: firstOptionPrice
		$secondOptionPrice = $I->executeJS("return '$' + (123.00 * (100 - 10)/100).toFixed(2);"); // stepKey: secondOptionPrice
		$I->comment("Assert product options price in storefront product page");
		$I->comment("Entering Action Group [assertCatalogPriceRuleAppliedToFirstProductOption] StorefrontAssertCatalogPriceRuleAppliedToProductOptionActionGroup");
		$I->selectOption("#product-options-wrapper .super-attribute-select", $I->retrieveEntityField('createConfigProductAttributeFirstOption', 'option[store_labels][1][label]', 'test')); // stepKey: selectOptionAssertCatalogPriceRuleAppliedToFirstProductOption
		$I->see("{$firstOptionPrice} Regular Price $123.00", "div.price-box.price-final_price"); // stepKey: seeProductPriceAssertCatalogPriceRuleAppliedToFirstProductOption
		$I->comment("Exiting Action Group [assertCatalogPriceRuleAppliedToFirstProductOption] StorefrontAssertCatalogPriceRuleAppliedToProductOptionActionGroup");
		$I->comment("Entering Action Group [assertCatalogPriceRuleAppliedToSecondProductOption] StorefrontAssertCatalogPriceRuleAppliedToProductOptionActionGroup");
		$I->selectOption("#product-options-wrapper .super-attribute-select", $I->retrieveEntityField('createConfigProductAttributeSecondOption', 'option[store_labels][1][label]', 'test')); // stepKey: selectOptionAssertCatalogPriceRuleAppliedToSecondProductOption
		$I->see("{$secondOptionPrice} Regular Price $123.00", "div.price-box.price-final_price"); // stepKey: seeProductPriceAssertCatalogPriceRuleAppliedToSecondProductOption
		$I->comment("Exiting Action Group [assertCatalogPriceRuleAppliedToSecondProductOption] StorefrontAssertCatalogPriceRuleAppliedToProductOptionActionGroup");
		$I->comment("Entering Action Group [assertCatalogPriceRuleAppliedToThirdProductOption] StorefrontAssertCatalogPriceRuleAppliedToProductOptionActionGroup");
		$I->selectOption("#product-options-wrapper .super-attribute-select", $I->retrieveEntityField('createConfigProductAttributeThirdOption', 'option[store_labels][1][label]', 'test')); // stepKey: selectOptionAssertCatalogPriceRuleAppliedToThirdProductOption
		$I->see("123.00", "div.price-box.price-final_price"); // stepKey: seeProductPriceAssertCatalogPriceRuleAppliedToThirdProductOption
		$I->comment("Exiting Action Group [assertCatalogPriceRuleAppliedToThirdProductOption] StorefrontAssertCatalogPriceRuleAppliedToProductOptionActionGroup");
		$I->comment("Add product with selected option to the cart");
		$I->comment("Entering Action Group [selectFirstOptionValue] StorefrontProductPageSelectDropDownOptionValueActionGroup");
		$I->selectOption("//*[@id='product-options-wrapper']//div[@class='fieldset']//label[contains(.,'" . $I->retrieveEntityField('createConfigProductAttribute', 'default_frontend_label', 'test') . "')]/../div[@class='control']//select", $I->retrieveEntityField('createConfigProductAttributeFirstOption', 'option[store_labels][1][label]', 'test')); // stepKey: fillDropDownAttributeOptionSelectFirstOptionValue
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadSelectFirstOptionValue
		$I->comment("Exiting Action Group [selectFirstOptionValue] StorefrontProductPageSelectDropDownOptionValueActionGroup");
		$I->comment("Entering Action Group [addFirstOptionToCart] AddToCartFromStorefrontProductPageActionGroup");
		$I->click("#product-addtocart-button"); // stepKey: addToCartAddFirstOptionToCart
		$I->waitForPageLoad(60); // stepKey: addToCartAddFirstOptionToCartWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForAddToCartAddFirstOptionToCart
		$I->waitForElementNotVisible("//button/span[text()='Adding...']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddingAddFirstOptionToCart
		$I->waitForElementNotVisible("//button/span[text()='Added']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddedAddFirstOptionToCart
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAddFirstOptionToCart
		$I->waitForElementVisible("div.message-success.success.message", 30); // stepKey: waitForSuccessMessageAddFirstOptionToCart
		$I->see("You added " . $I->retrieveEntityField('createConfigProduct', 'name', 'test') . " to your shopping cart.", "div.message-success.success.message"); // stepKey: seeAddToCartSuccessMessageAddFirstOptionToCart
		$I->comment("Exiting Action Group [addFirstOptionToCart] AddToCartFromStorefrontProductPageActionGroup");
		$I->comment("Entering Action Group [selectSecondOptionValue] StorefrontProductPageSelectDropDownOptionValueActionGroup");
		$I->selectOption("//*[@id='product-options-wrapper']//div[@class='fieldset']//label[contains(.,'" . $I->retrieveEntityField('createConfigProductAttribute', 'default_frontend_label', 'test') . "')]/../div[@class='control']//select", $I->retrieveEntityField('createConfigProductAttributeSecondOption', 'option[store_labels][1][label]', 'test')); // stepKey: fillDropDownAttributeOptionSelectSecondOptionValue
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadSelectSecondOptionValue
		$I->comment("Exiting Action Group [selectSecondOptionValue] StorefrontProductPageSelectDropDownOptionValueActionGroup");
		$I->comment("Entering Action Group [addSecondOptionToCart] AddToCartFromStorefrontProductPageActionGroup");
		$I->click("#product-addtocart-button"); // stepKey: addToCartAddSecondOptionToCart
		$I->waitForPageLoad(60); // stepKey: addToCartAddSecondOptionToCartWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForAddToCartAddSecondOptionToCart
		$I->waitForElementNotVisible("//button/span[text()='Adding...']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddingAddSecondOptionToCart
		$I->waitForElementNotVisible("//button/span[text()='Added']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddedAddSecondOptionToCart
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAddSecondOptionToCart
		$I->waitForElementVisible("div.message-success.success.message", 30); // stepKey: waitForSuccessMessageAddSecondOptionToCart
		$I->see("You added " . $I->retrieveEntityField('createConfigProduct', 'name', 'test') . " to your shopping cart.", "div.message-success.success.message"); // stepKey: seeAddToCartSuccessMessageAddSecondOptionToCart
		$I->comment("Exiting Action Group [addSecondOptionToCart] AddToCartFromStorefrontProductPageActionGroup");
		$I->comment("Entering Action Group [selectThirdOptionValue] StorefrontProductPageSelectDropDownOptionValueActionGroup");
		$I->selectOption("//*[@id='product-options-wrapper']//div[@class='fieldset']//label[contains(.,'" . $I->retrieveEntityField('createConfigProductAttribute', 'default_frontend_label', 'test') . "')]/../div[@class='control']//select", $I->retrieveEntityField('createConfigProductAttributeThirdOption', 'option[store_labels][1][label]', 'test')); // stepKey: fillDropDownAttributeOptionSelectThirdOptionValue
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadSelectThirdOptionValue
		$I->comment("Exiting Action Group [selectThirdOptionValue] StorefrontProductPageSelectDropDownOptionValueActionGroup");
		$I->comment("Entering Action Group [addThirdOptionToCart] AddToCartFromStorefrontProductPageActionGroup");
		$I->click("#product-addtocart-button"); // stepKey: addToCartAddThirdOptionToCart
		$I->waitForPageLoad(60); // stepKey: addToCartAddThirdOptionToCartWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForAddToCartAddThirdOptionToCart
		$I->waitForElementNotVisible("//button/span[text()='Adding...']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddingAddThirdOptionToCart
		$I->waitForElementNotVisible("//button/span[text()='Added']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddedAddThirdOptionToCart
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAddThirdOptionToCart
		$I->waitForElementVisible("div.message-success.success.message", 30); // stepKey: waitForSuccessMessageAddThirdOptionToCart
		$I->see("You added " . $I->retrieveEntityField('createConfigProduct', 'name', 'test') . " to your shopping cart.", "div.message-success.success.message"); // stepKey: seeAddToCartSuccessMessageAddThirdOptionToCart
		$I->comment("Exiting Action Group [addThirdOptionToCart] AddToCartFromStorefrontProductPageActionGroup");
		$I->comment("Assert product price in the cart");
		$I->comment("Entering Action Group [openCartPage] StorefrontOpenCartFromMinicartActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollToTopOfThePageOpenCartPage
		$I->waitForElement("a.showcart", 30); // stepKey: waitForShowMinicartOpenCartPage
		$I->waitForPageLoad(60); // stepKey: waitForShowMinicartOpenCartPageWaitForPageLoad
		$I->waitForElement(".action.viewcart", 30); // stepKey: waitForCartLinkOpenCartPage
		$I->waitForPageLoad(30); // stepKey: waitForCartLinkOpenCartPageWaitForPageLoad
		$I->click("a.showcart"); // stepKey: clickShowMinicartOpenCartPage
		$I->waitForPageLoad(60); // stepKey: clickShowMinicartOpenCartPageWaitForPageLoad
		$I->click(".action.viewcart"); // stepKey: clickCartOpenCartPage
		$I->waitForPageLoad(30); // stepKey: clickCartOpenCartPageWaitForPageLoad
		$I->comment("Exiting Action Group [openCartPage] StorefrontOpenCartFromMinicartActionGroup");
		$I->waitForElementVisible("//*[contains(@class, 'item-options')]/dd[normalize-space(.)='" . $I->retrieveEntityField('createConfigProductAttributeFirstOption', 'option[store_labels][1][label]', 'test') . "']/ancestor::tr//td[contains(@class, 'price')]//span[@class='price']", 30); // stepKey: waitForPriceAppears
		$I->see($firstOptionPrice, "//*[contains(@class, 'item-options')]/dd[normalize-space(.)='" . $I->retrieveEntityField('createConfigProductAttributeFirstOption', 'option[store_labels][1][label]', 'test') . "']/ancestor::tr//td[contains(@class, 'price')]//span[@class='price']"); // stepKey: assertProductPriceForFirstProductOption
		$I->see($secondOptionPrice, "//*[contains(@class, 'item-options')]/dd[normalize-space(.)='" . $I->retrieveEntityField('createConfigProductAttributeSecondOption', 'option[store_labels][1][label]', 'test') . "']/ancestor::tr//td[contains(@class, 'price')]//span[@class='price']"); // stepKey: assertProductPriceForSecondProductOption
		$I->see("123.00", "//*[contains(@class, 'item-options')]/dd[normalize-space(.)='" . $I->retrieveEntityField('createConfigProductAttributeThirdOption', 'option[store_labels][1][label]', 'test') . "']/ancestor::tr//td[contains(@class, 'price')]//span[@class='price']"); // stepKey: assertProductPriceForThirdProductOption
	}
}
