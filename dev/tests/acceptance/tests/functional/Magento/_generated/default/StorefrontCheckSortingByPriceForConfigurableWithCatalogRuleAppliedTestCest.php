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
 * @Title("MC-11926: Check sorting by price for Configurable product with Catalog Rule applied")
 * @Description("Sort by price should be correct if the apply Catalog Rule to child product of configurable product<h3>Test files</h3>app/code/Magento/ConfigurableProduct/Test/Mftf/Test/StorefrontSortingByPriceForConfigurableWithCatalogRuleAppliedTest.xml<br>")
 * @TestCaseId("MC-11926")
 * @group catalog
 * @group catalogRule
 * @group configurableProduct
 */
class StorefrontCheckSortingByPriceForConfigurableWithCatalogRuleAppliedTestCest
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
		$I->createEntity("createCategory", "hook", "ApiCategory", [], []); // stepKey: createCategory
		$createSimpleProductFields['price'] = "5.00";
		$I->createEntity("createSimpleProduct", "hook", "SimpleProduct", ["createCategory"], $createSimpleProductFields); // stepKey: createSimpleProduct
		$createSimpleProduct2Fields['price'] = "10.00";
		$I->createEntity("createSimpleProduct2", "hook", "SimpleProduct", ["createCategory"], $createSimpleProduct2Fields); // stepKey: createSimpleProduct2
		$I->createEntity("createConfigurableProduct", "hook", "ApiConfigurableProduct", ["createCategory"], []); // stepKey: createConfigurableProduct
		$I->createEntity("createConfigurableProductAttribute", "hook", "productAttributeWithTwoOptions", [], []); // stepKey: createConfigurableProductAttribute
		$I->createEntity("createConfigurableProductAttributeOption1", "hook", "productAttributeOption1", ["createConfigurableProductAttribute"], []); // stepKey: createConfigurableProductAttributeOption1
		$I->createEntity("createConfigurableProductAttributeOption2", "hook", "productAttributeOption2", ["createConfigurableProductAttribute"], []); // stepKey: createConfigurableProductAttributeOption2
		$I->createEntity("createConfigurableProductAttributeOption3", "hook", "productAttributeOption3", ["createConfigurableProductAttribute"], []); // stepKey: createConfigurableProductAttributeOption3
		$I->createEntity("createConfigAddToAttributeSet", "hook", "AddToDefaultSet", ["createConfigurableProductAttribute"], []); // stepKey: createConfigAddToAttributeSet
		$I->getEntity("getConfigAttributeOption1", "hook", "ProductAttributeOptionGetter", ["createConfigurableProductAttribute"], null, 1); // stepKey: getConfigAttributeOption1
		$I->getEntity("getConfigAttributeOption2", "hook", "ProductAttributeOptionGetter", ["createConfigurableProductAttribute"], null, 2); // stepKey: getConfigAttributeOption2
		$I->getEntity("getConfigAttributeOption3", "hook", "ProductAttributeOptionGetter", ["createConfigurableProductAttribute"], null, 3); // stepKey: getConfigAttributeOption3
		$createConfigChildProduct1Fields['price'] = "15.00";
		$I->createEntity("createConfigChildProduct1", "hook", "ApiSimpleOne", ["createConfigurableProductAttribute", "getConfigAttributeOption1"], $createConfigChildProduct1Fields); // stepKey: createConfigChildProduct1
		$createConfigChildProduct2Fields['price'] = "20.00";
		$I->createEntity("createConfigChildProduct2", "hook", "ApiSimpleTwo", ["createConfigurableProductAttribute", "getConfigAttributeOption2"], $createConfigChildProduct2Fields); // stepKey: createConfigChildProduct2
		$createConfigChildProduct3Fields['price'] = "25.00";
		$I->createEntity("createConfigChildProduct3", "hook", "ApiSimpleTwo", ["createConfigurableProductAttribute", "getConfigAttributeOption3"], $createConfigChildProduct3Fields); // stepKey: createConfigChildProduct3
		$I->createEntity("createConfigurableProductOption", "hook", "ConfigurableProductThreeOptions", ["createConfigurableProduct", "createConfigurableProductAttribute", "getConfigAttributeOption1", "getConfigAttributeOption2", "getConfigAttributeOption3"], []); // stepKey: createConfigurableProductOption
		$I->createEntity("createConfigurableProductAddChild1", "hook", "ConfigurableProductAddChild", ["createConfigurableProduct", "createConfigChildProduct1"], []); // stepKey: createConfigurableProductAddChild1
		$I->createEntity("createConfigurableProductAddChild2", "hook", "ConfigurableProductAddChild", ["createConfigurableProduct", "createConfigChildProduct2"], []); // stepKey: createConfigurableProductAddChild2
		$I->createEntity("createConfigurableProductAddChild3", "hook", "ConfigurableProductAddChild", ["createConfigurableProduct", "createConfigChildProduct3"], []); // stepKey: createConfigurableProductAddChild3
		$I->comment("Entering Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsAdmin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginAsAdmin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginAsAdmin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsAdmin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsAdminWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsAdmin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsAdmin
		$I->comment("Exiting Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->comment("SKU Product Attribute is enabled for Promo Rule Conditions");
		$I->comment("Entering Action Group [navigateToSkuProductAttribute] NavigateToEditProductAttributeActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product_attribute"); // stepKey: navigateToProductAttributeGridNavigateToSkuProductAttribute
		$I->fillField("#attributeGrid_filter_frontend_label", "sku"); // stepKey: navigateToAttributeEditPage1NavigateToSkuProductAttribute
		$I->click("button[data-action=grid-filter-apply]"); // stepKey: navigateToAttributeEditPage2NavigateToSkuProductAttribute
		$I->waitForPageLoad(30); // stepKey: navigateToAttributeEditPage2NavigateToSkuProductAttributeWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad2NavigateToSkuProductAttribute
		$I->click("//*[@id='attributeGrid_table']/tbody/tr[1]"); // stepKey: navigateToAttributeEditPage3NavigateToSkuProductAttribute
		$I->waitForPageLoad(30); // stepKey: navigateToAttributeEditPage3NavigateToSkuProductAttributeWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad3NavigateToSkuProductAttribute
		$I->comment("Exiting Action Group [navigateToSkuProductAttribute] NavigateToEditProductAttributeActionGroup");
		$I->comment("Entering Action Group [changeUseForPromoRuleConditionsProductAttributeToYes] ChangeUseForPromoRuleConditionsProductAttributeActionGroup");
		$I->click("#product_attribute_tabs_front"); // stepKey: clickStoreFrontPropertiesTabChangeUseForPromoRuleConditionsProductAttributeToYes
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadChangeUseForPromoRuleConditionsProductAttributeToYes
		$I->selectOption("#is_used_for_promo_rules", "Yes"); // stepKey: changeOptionChangeUseForPromoRuleConditionsProductAttributeToYes
		$I->click("#save"); // stepKey: saveAttributeChangeUseForPromoRuleConditionsProductAttributeToYes
		$I->waitForPageLoad(30); // stepKey: saveAttributeChangeUseForPromoRuleConditionsProductAttributeToYesWaitForPageLoad
		$I->see("You saved the product attribute.", "#messages div.message-success"); // stepKey: successMessageChangeUseForPromoRuleConditionsProductAttributeToYes
		$I->comment("Exiting Action Group [changeUseForPromoRuleConditionsProductAttributeToYes] ChangeUseForPromoRuleConditionsProductAttributeActionGroup");
		$reindexInvalidatedIndices = $I->magentoCron("index", 90); // stepKey: reindexInvalidatedIndices
		$I->comment($reindexInvalidatedIndices);
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->deleteEntity("createCategory", "hook"); // stepKey: deleteCategory
		$I->deleteEntity("createSimpleProduct", "hook"); // stepKey: deleteSimpleProduct
		$I->deleteEntity("createSimpleProduct2", "hook"); // stepKey: deleteSimpleProduct2
		$I->deleteEntity("createConfigChildProduct1", "hook"); // stepKey: deleteConfigChildProduct1
		$I->deleteEntity("createConfigChildProduct2", "hook"); // stepKey: deleteConfigChildProduct2
		$I->deleteEntity("createConfigChildProduct3", "hook"); // stepKey: deleteConfigChildProduct3
		$I->deleteEntity("createConfigurableProduct", "hook"); // stepKey: deleteConfigProduct
		$I->deleteEntity("createConfigurableProductAttribute", "hook"); // stepKey: deleteConfigProductAttribute
		$I->comment("SKU Product Attribute is disable for Promo Rule Conditions");
		$I->comment("Entering Action Group [navigateToSkuProductAttribute] NavigateToEditProductAttributeActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product_attribute"); // stepKey: navigateToProductAttributeGridNavigateToSkuProductAttribute
		$I->fillField("#attributeGrid_filter_frontend_label", "sku"); // stepKey: navigateToAttributeEditPage1NavigateToSkuProductAttribute
		$I->click("button[data-action=grid-filter-apply]"); // stepKey: navigateToAttributeEditPage2NavigateToSkuProductAttribute
		$I->waitForPageLoad(30); // stepKey: navigateToAttributeEditPage2NavigateToSkuProductAttributeWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad2NavigateToSkuProductAttribute
		$I->click("//*[@id='attributeGrid_table']/tbody/tr[1]"); // stepKey: navigateToAttributeEditPage3NavigateToSkuProductAttribute
		$I->waitForPageLoad(30); // stepKey: navigateToAttributeEditPage3NavigateToSkuProductAttributeWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad3NavigateToSkuProductAttribute
		$I->comment("Exiting Action Group [navigateToSkuProductAttribute] NavigateToEditProductAttributeActionGroup");
		$I->comment("Entering Action Group [changeUseForPromoRuleConditionsProductAttributeToNo] ChangeUseForPromoRuleConditionsProductAttributeActionGroup");
		$I->click("#product_attribute_tabs_front"); // stepKey: clickStoreFrontPropertiesTabChangeUseForPromoRuleConditionsProductAttributeToNo
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadChangeUseForPromoRuleConditionsProductAttributeToNo
		$I->selectOption("#is_used_for_promo_rules", "No"); // stepKey: changeOptionChangeUseForPromoRuleConditionsProductAttributeToNo
		$I->click("#save"); // stepKey: saveAttributeChangeUseForPromoRuleConditionsProductAttributeToNo
		$I->waitForPageLoad(30); // stepKey: saveAttributeChangeUseForPromoRuleConditionsProductAttributeToNoWaitForPageLoad
		$I->see("You saved the product attribute.", "#messages div.message-success"); // stepKey: successMessageChangeUseForPromoRuleConditionsProductAttributeToNo
		$I->comment("Exiting Action Group [changeUseForPromoRuleConditionsProductAttributeToNo] ChangeUseForPromoRuleConditionsProductAttributeActionGroup");
		$I->comment("Entering Action Group [deleteCatalogPriceRule] RemoveCatalogPriceRuleActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog_rule/promo_catalog/"); // stepKey: goToAdminCatalogPriceRuleGridPageDeleteCatalogPriceRule
		$I->waitForPageLoad(30); // stepKey: waitForAdminCatalogPriceRuleGridPageLoadDeleteCatalogPriceRule
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clearExistingFiltersDeleteCatalogPriceRule
		$I->waitForPageLoad(30); // stepKey: clearExistingFiltersDeleteCatalogPriceRuleWaitForPageLoad
		$I->fillField("#promo_catalog_grid_filter_name", "CatalogPriceRule" . msq("_defaultCatalogRule")); // stepKey: filterByRuleNameDeleteCatalogPriceRule
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickSearchDeleteCatalogPriceRule
		$I->waitForPageLoad(30); // stepKey: clickSearchDeleteCatalogPriceRuleWaitForPageLoad
		$I->click("table.data-grid tbody tr[data-role=row]:nth-of-type(1)"); // stepKey: clickEditDeleteCatalogPriceRule
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadDeleteCatalogPriceRule
		$I->click("#delete"); // stepKey: clickToDeleteDeleteCatalogPriceRule
		$I->waitForPageLoad(30); // stepKey: clickToDeleteDeleteCatalogPriceRuleWaitForPageLoad
		$I->waitForElementVisible("aside.confirm .modal-footer button.action-accept", 30); // stepKey: waitForElementVisibleDeleteCatalogPriceRule
		$I->waitForPageLoad(60); // stepKey: waitForElementVisibleDeleteCatalogPriceRuleWaitForPageLoad
		$I->click("aside.confirm .modal-footer button.action-accept"); // stepKey: clickToConfirmDeleteCatalogPriceRule
		$I->waitForPageLoad(60); // stepKey: clickToConfirmDeleteCatalogPriceRuleWaitForPageLoad
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitForSuccessMessageDeleteCatalogPriceRule
		$I->see("You deleted the rule.", "#messages div.message-success"); // stepKey: verifyRuleIsDeletedDeleteCatalogPriceRule
		$I->comment("Exiting Action Group [deleteCatalogPriceRule] RemoveCatalogPriceRuleActionGroup");
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
	 * @Features({"ConfigurableProduct"})
	 * @Stories({"Check sorting by price on storefront"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function StorefrontCheckSortingByPriceForConfigurableWithCatalogRuleAppliedTest(AcceptanceTester $I)
	{
		$I->comment("Open category with products and Sort by price desc");
		$I->comment("Entering Action Group [goToStorefrontCategoryPage] GoToStorefrontCategoryPageByParametersActionGroup");
		$I->comment("Go to storefront category page");
		$I->amOnPage("/" . $I->retrieveEntityField('createCategory', 'custom_attributes[url_key]', 'test') . ".html?product_list_limit=25&product_list_mode=grid&product_list_order=price&product_list_dir=desc"); // stepKey: onCategoryPageGoToStorefrontCategoryPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadGoToStorefrontCategoryPage
		$I->comment("Exiting Action Group [goToStorefrontCategoryPage] GoToStorefrontCategoryPageByParametersActionGroup");
		$I->see($I->retrieveEntityField('createConfigurableProduct', 'name', 'test'), ".products.list.items.product-items li:nth-of-type(1) .product-item-link"); // stepKey: seeConfigurableProduct
		$I->waitForPageLoad(30); // stepKey: seeConfigurableProductWaitForPageLoad
		$I->see($I->retrieveEntityField('createSimpleProduct2', 'name', 'test'), ".products.list.items.product-items li:nth-of-type(2) .product-item-link"); // stepKey: seeSimpleProductTwo
		$I->waitForPageLoad(30); // stepKey: seeSimpleProductTwoWaitForPageLoad
		$I->see($I->retrieveEntityField('createSimpleProduct', 'name', 'test'), ".products.list.items.product-items li:nth-of-type(3) .product-item-link"); // stepKey: seeSimpleProduct
		$I->waitForPageLoad(30); // stepKey: seeSimpleProductWaitForPageLoad
		$I->comment("Create and apply catalog price rule");
		$I->comment("Entering Action Group [startCreatingCatalogPriceRule] AdminOpenNewCatalogPriceRuleFormPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog_rule/promo_catalog/new/"); // stepKey: openNewCatalogPriceRulePageStartCreatingCatalogPriceRule
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadStartCreatingCatalogPriceRule
		$I->comment("Exiting Action Group [startCreatingCatalogPriceRule] AdminOpenNewCatalogPriceRuleFormPageActionGroup");
		$I->comment("Entering Action Group [fillMainInfoForCatalogPriceRule] AdminCatalogPriceRuleFillMainInfoActionGroup");
		$I->fillField("[name='name']", "CatalogPriceRule" . msq("_defaultCatalogRule")); // stepKey: fillNameFillMainInfoForCatalogPriceRule
		$I->fillField("[name='description']", "Catalog Price Rule Description"); // stepKey: fillDescriptionFillMainInfoForCatalogPriceRule
		$I->conditionalClick("input[name='is_active']+label", "div.admin__actions-switch input[name='is_active'][value='1']+label", false); // stepKey: fillActiveFillMainInfoForCatalogPriceRule
		$I->selectOption("[name='website_ids']", ['Main Website']); // stepKey: selectSpecifiedWebsitesFillMainInfoForCatalogPriceRule
		$I->selectOption("[name='customer_group_ids']", ['NOT LOGGED IN']); // stepKey: selectSpecifiedCustomerGroupsFillMainInfoForCatalogPriceRule
		$I->fillField("[name='from_date']", ""); // stepKey: fillFromDateFillMainInfoForCatalogPriceRule
		$I->fillField("[name='to_date']", ""); // stepKey: fillToDateFillMainInfoForCatalogPriceRule
		$I->fillField("[name='sort_order']", ""); // stepKey: fillPriorityFillMainInfoForCatalogPriceRule
		$I->comment("Exiting Action Group [fillMainInfoForCatalogPriceRule] AdminCatalogPriceRuleFillMainInfoActionGroup");
		$I->comment("Entering Action Group [addProductSkuBasedCondition] AdminCatalogPriceRuleAddSkuConditionActionGroup");
		$I->conditionalClick("[data-index='block_promo_catalog_edit_tab_conditions'] .fieldset-wrapper-title", "[data-index='block_promo_catalog_edit_tab_conditions'] .admin__fieldset-wrapper-content", false); // stepKey: openConditionsSectionIfNeededAddProductSkuBasedCondition
		$I->scrollTo("[data-index='block_promo_catalog_edit_tab_conditions'] .fieldset-wrapper-title"); // stepKey: scrollToConditionsFieldsetAddProductSkuBasedCondition
		$I->waitForElementVisible(".rule-param.rule-param-new-child", 30); // stepKey: waitForNewConditionButtonAddProductSkuBasedCondition
		$I->waitForPageLoad(30); // stepKey: waitForNewConditionButtonAddProductSkuBasedConditionWaitForPageLoad
		$I->click(".rule-param.rule-param-new-child"); // stepKey: clickAddNewConditionButtonAddProductSkuBasedCondition
		$I->waitForPageLoad(30); // stepKey: clickAddNewConditionButtonAddProductSkuBasedConditionWaitForPageLoad
		$I->selectOption("select#conditions__1__new_child", "Magento\CatalogRule\Model\Rule\Condition\Product|sku"); // stepKey: selectConditionTypeSkuAddProductSkuBasedCondition
		$I->waitForPageLoad(30); // stepKey: selectConditionTypeSkuAddProductSkuBasedConditionWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitConditionFormRefreshAddProductSkuBasedCondition
		$I->click("//li[1]//a[@class='label'][text() = '...']"); // stepKey: clickEllipsisAddProductSkuBasedCondition
		$I->fillField("input#conditions__1--1__value", $I->retrieveEntityField('createConfigChildProduct3', 'sku', 'test')); // stepKey: fillProductSkuAddProductSkuBasedCondition
		$I->click("#conditions__1__children li:nth-of-type(1) a.rule-param-apply"); // stepKey: clickApplyAddProductSkuBasedCondition
		$I->waitForPageLoad(30); // stepKey: clickApplyAddProductSkuBasedConditionWaitForPageLoad
		$I->comment("Exiting Action Group [addProductSkuBasedCondition] AdminCatalogPriceRuleAddSkuConditionActionGroup");
		$I->comment("Entering Action Group [fillActionsForCatalogPriceRule] AdminCatalogPriceRuleFillActionsActionGroup");
		$I->conditionalClick("[data-index='actions'] .fieldset-wrapper-title", "[data-index='actions'] .admin__fieldset-wrapper-content", false); // stepKey: openActionSectionIfNeededFillActionsForCatalogPriceRule
		$I->scrollTo("[data-index='actions'] .fieldset-wrapper-title"); // stepKey: scrollToActionsFieldsetFillActionsForCatalogPriceRule
		$I->waitForElementVisible("[name='simple_action']", 30); // stepKey: waitActionsFieldsetFullyOpenedFillActionsForCatalogPriceRule
		$I->selectOption("[name='simple_action']", "by_percent"); // stepKey: fillDiscountTypeFillActionsForCatalogPriceRule
		$I->fillField("[name='discount_amount']", "96"); // stepKey: fillDiscountAmountFillActionsForCatalogPriceRule
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
		$I->comment("Entering Action Group [fullCache] CliCacheCleanActionGroup");
		$cleanSpecifiedCacheFullCache = $I->magentoCLI("cache:clean", 60, "full_page"); // stepKey: cleanSpecifiedCacheFullCache
		$I->comment($cleanSpecifiedCacheFullCache);
		$I->comment("Exiting Action Group [fullCache] CliCacheCleanActionGroup");
		$I->comment("Reopen category with products and Sort by price desc");
		$I->comment("Entering Action Group [goToStorefrontCategoryPage2] GoToStorefrontCategoryPageByParametersActionGroup");
		$I->comment("Go to storefront category page");
		$I->amOnPage("/" . $I->retrieveEntityField('createCategory', 'custom_attributes[url_key]', 'test') . ".html?product_list_limit=9&product_list_mode=grid&product_list_order=price&product_list_dir=desc"); // stepKey: onCategoryPageGoToStorefrontCategoryPage2
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadGoToStorefrontCategoryPage2
		$I->comment("Exiting Action Group [goToStorefrontCategoryPage2] GoToStorefrontCategoryPageByParametersActionGroup");
		$I->see($I->retrieveEntityField('createSimpleProduct2', 'name', 'test'), ".products.list.items.product-items li:nth-of-type(1) .product-item-link"); // stepKey: seeSimpleProductTwo2
		$I->waitForPageLoad(30); // stepKey: seeSimpleProductTwo2WaitForPageLoad
		$I->see($I->retrieveEntityField('createSimpleProduct', 'name', 'test'), ".products.list.items.product-items li:nth-of-type(2) .product-item-link"); // stepKey: seeSimpleProduct2
		$I->waitForPageLoad(30); // stepKey: seeSimpleProduct2WaitForPageLoad
		$I->see($I->retrieveEntityField('createConfigurableProduct', 'name', 'test'), ".products.list.items.product-items li:nth-of-type(3) .product-item-link"); // stepKey: seeConfigurableProduct2
		$I->waitForPageLoad(30); // stepKey: seeConfigurableProduct2WaitForPageLoad
	}
}
