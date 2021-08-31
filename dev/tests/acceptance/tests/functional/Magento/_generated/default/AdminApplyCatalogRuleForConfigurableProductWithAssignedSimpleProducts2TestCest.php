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
 * @Title("MC-27708: Apply catalog rule for configurable product with assigned simple products")
 * @Description("Admin should be able to apply catalog rule for configurable product with assigned simple products<h3>Test files</h3>app/code/Magento/CatalogRuleConfigurable/Test/Mftf/Test/AdminApplyCatalogRuleForConfigurableProductWithAssignedSimpleProducts2Test.xml<br>")
 * @TestCaseId("MC-27708")
 * @group catalog
 * @group configurable_product
 * @group catalog_rule_configurable
 * @group mtf_migrated
 */
class AdminApplyCatalogRuleForConfigurableProductWithAssignedSimpleProducts2TestCest
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
		$I->comment("Create category for first configurable product");
		$I->createEntity("firstSimpleCategory", "hook", "SimpleSubCategory", [], []); // stepKey: firstSimpleCategory
		$I->comment("Create first configurable product with two options");
		$I->createEntity("createFirstConfigProduct", "hook", "ApiConfigurableProduct", ["firstSimpleCategory"], []); // stepKey: createFirstConfigProduct
		$I->createEntity("createFirstConfigProductAttribute", "hook", "productAttributeWithTwoOptions", [], []); // stepKey: createFirstConfigProductAttribute
		$I->createEntity("createFirstConfigProductAttributeFirstOption", "hook", "productAttributeOption1", ["createFirstConfigProductAttribute"], []); // stepKey: createFirstConfigProductAttributeFirstOption
		$I->createEntity("createFirstConfigProductAttributeSecondOption", "hook", "productAttributeOption2", ["createFirstConfigProductAttribute"], []); // stepKey: createFirstConfigProductAttributeSecondOption
		$I->createEntity("addFirstProductToAttributeSet", "hook", "AddToDefaultSet", ["createFirstConfigProductAttribute"], []); // stepKey: addFirstProductToAttributeSet
		$I->getEntity("getFirstConfigAttributeFirstOption", "hook", "ProductAttributeOptionGetter", ["createFirstConfigProductAttribute"], null, 1); // stepKey: getFirstConfigAttributeFirstOption
		$I->getEntity("getFirstConfigAttributeSecondOption", "hook", "ProductAttributeOptionGetter", ["createFirstConfigProductAttribute"], null, 2); // stepKey: getFirstConfigAttributeSecondOption
		$I->comment("Create two child products for first configurable product");
		$I->createEntity("createFirstConfigFirstChildProduct", "hook", "ApiSimpleOne", ["createFirstConfigProductAttribute", "getFirstConfigAttributeFirstOption"], []); // stepKey: createFirstConfigFirstChildProduct
		$I->createEntity("createFirstConfigSecondChildProduct", "hook", "ApiSimpleOne", ["createFirstConfigProductAttribute", "getFirstConfigAttributeSecondOption"], []); // stepKey: createFirstConfigSecondChildProduct
		$I->createEntity("createFirstConfigProductOption", "hook", "ConfigurableProductTwoOptions", ["createFirstConfigProduct", "createFirstConfigProductAttribute", "getFirstConfigAttributeFirstOption", "getFirstConfigAttributeSecondOption"], []); // stepKey: createFirstConfigProductOption
		$I->createEntity("createFirstConfigProductAddFirstChild", "hook", "ConfigurableProductAddChild", ["createFirstConfigProduct", "createFirstConfigFirstChildProduct"], []); // stepKey: createFirstConfigProductAddFirstChild
		$I->createEntity("createFirstConfigProductAddSecondChild", "hook", "ConfigurableProductAddChild", ["createFirstConfigProduct", "createFirstConfigSecondChildProduct"], []); // stepKey: createFirstConfigProductAddSecondChild
		$I->comment("Add customizable options to first product");
		$I->updateEntity("createFirstConfigProduct", "hook", "productWithOptionRadiobutton",[]); // stepKey: updateFirstProductWithOption
		$I->comment("Create category for second configurable product");
		$I->createEntity("secondSimpleCategory", "hook", "SimpleSubCategory", [], []); // stepKey: secondSimpleCategory
		$I->comment("Create second configurable product with two options");
		$I->createEntity("createSecondConfigProduct", "hook", "ApiConfigurableProduct", ["secondSimpleCategory"], []); // stepKey: createSecondConfigProduct
		$I->createEntity("createSecondConfigProductAttribute", "hook", "productAttributeWithTwoOptions", [], []); // stepKey: createSecondConfigProductAttribute
		$I->createEntity("createSecondConfigProductAttributeFirstOption", "hook", "productAttributeOption1", ["createSecondConfigProductAttribute"], []); // stepKey: createSecondConfigProductAttributeFirstOption
		$I->createEntity("createSecondConfigProductAttributeSecondOption", "hook", "productAttributeOption2", ["createSecondConfigProductAttribute"], []); // stepKey: createSecondConfigProductAttributeSecondOption
		$I->createEntity("addSecondProductToAttributeSet", "hook", "AddToDefaultSet", ["createSecondConfigProductAttribute"], []); // stepKey: addSecondProductToAttributeSet
		$I->getEntity("getSecondConfigAttributeFirstOption", "hook", "ProductAttributeOptionGetter", ["createSecondConfigProductAttribute"], null, 1); // stepKey: getSecondConfigAttributeFirstOption
		$I->getEntity("getSecondConfigAttributeSecondOption", "hook", "ProductAttributeOptionGetter", ["createSecondConfigProductAttribute"], null, 2); // stepKey: getSecondConfigAttributeSecondOption
		$I->comment("Create two child products for second configurable product");
		$I->createEntity("createSecondConfigFirstChildProduct", "hook", "ApiSimpleOne", ["createSecondConfigProductAttribute", "getSecondConfigAttributeFirstOption"], []); // stepKey: createSecondConfigFirstChildProduct
		$I->createEntity("createSecondConfigSecondChildProduct", "hook", "ApiSimpleOne", ["createSecondConfigProductAttribute", "getSecondConfigAttributeSecondOption"], []); // stepKey: createSecondConfigSecondChildProduct
		$I->createEntity("createSecondConfigProductOption", "hook", "ConfigurableProductTwoOptions", ["createSecondConfigProduct", "createSecondConfigProductAttribute", "getSecondConfigAttributeFirstOption", "getSecondConfigAttributeSecondOption"], []); // stepKey: createSecondConfigProductOption
		$I->createEntity("createSecondConfigProductAddFirstChild", "hook", "ConfigurableProductAddChild", ["createSecondConfigProduct", "createSecondConfigFirstChildProduct"], []); // stepKey: createSecondConfigProductAddFirstChild
		$I->createEntity("createSecondConfigProductAddSecondChild", "hook", "ConfigurableProductAddChild", ["createSecondConfigProduct", "createSecondConfigSecondChildProduct"], []); // stepKey: createSecondConfigProductAddSecondChild
		$I->comment("Add customizable options to second product");
		$I->updateEntity("createSecondConfigProduct", "hook", "productWithOptionRadiobutton",[]); // stepKey: updateSecondProductWithOption
		$I->comment("Create customer group");
		$I->createEntity("customerGroup", "hook", "CustomCustomerGroup", [], []); // stepKey: customerGroup
		$I->comment("Create Customer");
		$I->createEntity("createCustomer", "hook", "SimpleUsCustomerWithNewCustomerGroup", ["customerGroup"], []); // stepKey: createCustomer
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
		$I->deleteEntity("createFirstConfigProduct", "hook"); // stepKey: deleteFirstConfigProduct
		$I->deleteEntity("createFirstConfigFirstChildProduct", "hook"); // stepKey: deleteFirstConfigFirstChildProduct
		$I->deleteEntity("createFirstConfigSecondChildProduct", "hook"); // stepKey: deleteFirstConfigSecondChildProduct
		$I->deleteEntity("createFirstConfigProductAttribute", "hook"); // stepKey: deleteFirstConfigProductAttribute
		$I->deleteEntity("firstSimpleCategory", "hook"); // stepKey: deleteFirstSimpleCategory
		$I->deleteEntity("createSecondConfigProduct", "hook"); // stepKey: deleteSecondConfigProduct
		$I->deleteEntity("createSecondConfigFirstChildProduct", "hook"); // stepKey: deleteSecondConfigFirstChildProduct
		$I->deleteEntity("createSecondConfigSecondChildProduct", "hook"); // stepKey: deleteSecondConfigSecondChildProduct
		$I->deleteEntity("createSecondConfigProductAttribute", "hook"); // stepKey: deleteSecondConfigProductAttribute
		$I->deleteEntity("secondSimpleCategory", "hook"); // stepKey: deleteSimpleCategory
		$I->comment("Customer log out");
		$I->comment("Must logout before delete customer otherwise magento fails during logout");
		$I->comment("Entering Action Group [logoutFromStorefront] StorefrontCustomerLogoutActionGroup");
		$I->amOnPage("customer/account/logout/"); // stepKey: storefrontSignOutLogoutFromStorefront
		$I->waitForPageLoad(30); // stepKey: waitForSignOutLogoutFromStorefront
		$I->comment("Exiting Action Group [logoutFromStorefront] StorefrontCustomerLogoutActionGroup");
		$I->deleteEntity("createCustomer", "hook"); // stepKey: deleteCustomer
		$I->deleteEntity("customerGroup", "hook"); // stepKey: deleteCustomerGroup
		$I->comment("Delete created price rules");
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
		$I->comment("Admin log out");
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
	public function AdminApplyCatalogRuleForConfigurableProductWithAssignedSimpleProducts2Test(AcceptanceTester $I)
	{
		$I->comment("Create catalog price rule");
		$customerGroupName = $I->executeJS("return '" . $I->retrieveEntityField('customerGroup', 'code', 'test') . "'"); // stepKey: customerGroupName
		$I->comment("Entering Action Group [startCreatingCatalogPriceRule] AdminOpenNewCatalogPriceRuleFormPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog_rule/promo_catalog/new/"); // stepKey: openNewCatalogPriceRulePageStartCreatingCatalogPriceRule
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadStartCreatingCatalogPriceRule
		$I->comment("Exiting Action Group [startCreatingCatalogPriceRule] AdminOpenNewCatalogPriceRuleFormPageActionGroup");
		$I->comment("Entering Action Group [fillMainInfoForCatalogPriceRule] AdminCatalogPriceRuleFillMainInfoActionGroup");
		$I->fillField("[name='name']", "CatalogPriceRule" . msq("_defaultCatalogRule")); // stepKey: fillNameFillMainInfoForCatalogPriceRule
		$I->fillField("[name='description']", "Catalog Price Rule Description"); // stepKey: fillDescriptionFillMainInfoForCatalogPriceRule
		$I->conditionalClick("input[name='is_active']+label", "div.admin__actions-switch input[name='is_active'][value='1']+label", false); // stepKey: fillActiveFillMainInfoForCatalogPriceRule
		$I->selectOption("[name='website_ids']", ['Main Website']); // stepKey: selectSpecifiedWebsitesFillMainInfoForCatalogPriceRule
		$I->selectOption("[name='customer_group_ids']", ["{$customerGroupName}"]); // stepKey: selectSpecifiedCustomerGroupsFillMainInfoForCatalogPriceRule
		$I->fillField("[name='from_date']", ""); // stepKey: fillFromDateFillMainInfoForCatalogPriceRule
		$I->fillField("[name='to_date']", ""); // stepKey: fillToDateFillMainInfoForCatalogPriceRule
		$I->fillField("[name='sort_order']", ""); // stepKey: fillPriorityFillMainInfoForCatalogPriceRule
		$I->comment("Exiting Action Group [fillMainInfoForCatalogPriceRule] AdminCatalogPriceRuleFillMainInfoActionGroup");
		$I->comment("Entering Action Group [fillActionsForCatalogPriceRule] AdminCatalogPriceRuleFillActionsActionGroup");
		$I->conditionalClick("[data-index='actions'] .fieldset-wrapper-title", "[data-index='actions'] .admin__fieldset-wrapper-content", false); // stepKey: openActionSectionIfNeededFillActionsForCatalogPriceRule
		$I->scrollTo("[data-index='actions'] .fieldset-wrapper-title"); // stepKey: scrollToActionsFieldsetFillActionsForCatalogPriceRule
		$I->waitForElementVisible("[name='simple_action']", 30); // stepKey: waitActionsFieldsetFullyOpenedFillActionsForCatalogPriceRule
		$I->selectOption("[name='simple_action']", "to_fixed"); // stepKey: fillDiscountTypeFillActionsForCatalogPriceRule
		$I->fillField("[name='discount_amount']", "110.7"); // stepKey: fillDiscountAmountFillActionsForCatalogPriceRule
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
		$I->comment("Adding the comment to replace AdminReindexAndFlushCache action group ('indexer:reindex', 'cache:flush' commands) for preserving Backward Compatibility");
		$I->comment("Login to storefront from customer");
		$I->comment("Entering Action Group [loginCustomerOnStorefront] LoginToStorefrontActionGroup");
		$I->amOnPage("/customer/account/login/"); // stepKey: amOnSignInPageLoginCustomerOnStorefront
		$I->waitForPageLoad(30); // stepKey: waitPageFullyLoadedLoginCustomerOnStorefront
		$I->waitForElementVisible("#email", 30); // stepKey: waitFormAppearsLoginCustomerOnStorefront
		$I->fillField("#email", $I->retrieveEntityField('createCustomer', 'email', 'test')); // stepKey: fillEmailLoginCustomerOnStorefront
		$I->fillField("#pass", $I->retrieveEntityField('createCustomer', 'password', 'test')); // stepKey: fillPasswordLoginCustomerOnStorefront
		$I->click("#send2"); // stepKey: clickSignInAccountButtonLoginCustomerOnStorefront
		$I->waitForPageLoad(30); // stepKey: clickSignInAccountButtonLoginCustomerOnStorefrontWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCustomerLoggedInLoginCustomerOnStorefront
		$I->comment("Exiting Action Group [loginCustomerOnStorefront] LoginToStorefrontActionGroup");
		$I->comment("Assert first product in category");
		$I->amOnPage("/" . $I->retrieveEntityField('firstSimpleCategory', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: goToFirstCategoryPageStorefront
		$I->waitForPageLoad(30); // stepKey: waitForFirstCategoryPageLoad
		$I->comment("Entering Action Group [checkFirstProductPriceInCategory] StorefrontCheckCategoryConfigurableProductWithUpdatedPriceActionGroup");
		$I->seeElement("//main//li//a[contains(text(), '" . $I->retrieveEntityField('createFirstConfigProduct', 'name', 'test') . "')]"); // stepKey: assertProductNameCheckFirstProductPriceInCategory
		$I->see("110.7", "//main//li[.//a[contains(text(), '" . $I->retrieveEntityField('createFirstConfigProduct', 'name', 'test') . "')]]//span[@class='price']"); // stepKey: AssertProductPriceCheckFirstProductPriceInCategory
		$I->moveMouseOver("//main//li[.//a[contains(text(), '" . $I->retrieveEntityField('createFirstConfigProduct', 'name', 'test') . "')]]//div[@class='product-item-info']"); // stepKey: moveMouseOverProductCheckFirstProductPriceInCategory
		$I->seeElement("//main//li[.//a[contains(text(), '" . $I->retrieveEntityField('createFirstConfigProduct', 'name', 'test') . "')]]//button[contains(@class, 'tocart')]"); // stepKey: AssertAddToCartCheckFirstProductPriceInCategory
		$I->comment("Exiting Action Group [checkFirstProductPriceInCategory] StorefrontCheckCategoryConfigurableProductWithUpdatedPriceActionGroup");
		$I->comment("Assert second product in category");
		$I->amOnPage("/" . $I->retrieveEntityField('secondSimpleCategory', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: goToSecondCategoryPageStorefront
		$I->waitForPageLoad(30); // stepKey: waitForSecondCategoryPageLoad
		$I->comment("Entering Action Group [checkSecondProductPriceInCategory] StorefrontCheckCategoryConfigurableProductWithUpdatedPriceActionGroup");
		$I->seeElement("//main//li//a[contains(text(), '" . $I->retrieveEntityField('createSecondConfigProduct', 'name', 'test') . "')]"); // stepKey: assertProductNameCheckSecondProductPriceInCategory
		$I->see("110.7", "//main//li[.//a[contains(text(), '" . $I->retrieveEntityField('createSecondConfigProduct', 'name', 'test') . "')]]//span[@class='price']"); // stepKey: AssertProductPriceCheckSecondProductPriceInCategory
		$I->moveMouseOver("//main//li[.//a[contains(text(), '" . $I->retrieveEntityField('createSecondConfigProduct', 'name', 'test') . "')]]//div[@class='product-item-info']"); // stepKey: moveMouseOverProductCheckSecondProductPriceInCategory
		$I->seeElement("//main//li[.//a[contains(text(), '" . $I->retrieveEntityField('createSecondConfigProduct', 'name', 'test') . "')]]//button[contains(@class, 'tocart')]"); // stepKey: AssertAddToCartCheckSecondProductPriceInCategory
		$I->comment("Exiting Action Group [checkSecondProductPriceInCategory] StorefrontCheckCategoryConfigurableProductWithUpdatedPriceActionGroup");
		$I->comment("Assert first product in storefront product page");
		$I->amOnPage("/" . $I->retrieveEntityField('createFirstConfigProduct', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: amOnFirstProductPage
		$I->waitForPageLoad(30); // stepKey: waitForFirstProductPageLoad
		$I->comment("Entering Action Group [checkFirstProductPriceInStorefrontProductPage] StorefrontAssertUpdatedProductPriceInStorefrontProductPageActionGroup");
		$I->seeInTitle($I->retrieveEntityField('createFirstConfigProduct', 'name', 'test')); // stepKey: assertProductNameTitleCheckFirstProductPriceInStorefrontProductPage
		$I->see($I->retrieveEntityField('createFirstConfigProduct', 'name', 'test'), ".base"); // stepKey: assertProductNameCheckFirstProductPriceInStorefrontProductPage
		$I->see("110.7", "div.price-box.price-final_price"); // stepKey: assertProductPriceCheckFirstProductPriceInStorefrontProductPage
		$I->comment("Exiting Action Group [checkFirstProductPriceInStorefrontProductPage] StorefrontAssertUpdatedProductPriceInStorefrontProductPageActionGroup");
		$I->comment("Add first product with selected options to the cart");
		$I->comment("Entering Action Group [firstConfigProductSelectFirstOptionValue] StorefrontProductPageSelectDropDownOptionValueActionGroup");
		$I->selectOption("//*[@id='product-options-wrapper']//div[@class='fieldset']//label[contains(.,'" . $I->retrieveEntityField('createFirstConfigProductAttribute', 'default_frontend_label', 'test') . "')]/../div[@class='control']//select", $I->retrieveEntityField('createFirstConfigProductAttributeFirstOption', 'option[store_labels][1][label]', 'test')); // stepKey: fillDropDownAttributeOptionFirstConfigProductSelectFirstOptionValue
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadFirstConfigProductSelectFirstOptionValue
		$I->comment("Exiting Action Group [firstConfigProductSelectFirstOptionValue] StorefrontProductPageSelectDropDownOptionValueActionGroup");
		$I->comment("Entering Action Group [firstConfigProductSelectSecondOptionValue] StorefrontProductPageSelectRadioButtonOptionValueActionGroup");
		$I->checkOption("//*[@id='product-options-wrapper']//div[contains(@class,'fieldset')]//label[contains(.,'OptionRadioButtons')]/../div[contains(@class,'control')]//label[contains(@class,'label') and contains(.,'OptionValueRadioButtons1')]/preceding-sibling::input[@type='radio']"); // stepKey: fillRadioButtonAttributeOptionFirstConfigProductSelectSecondOptionValue
		$I->comment("Exiting Action Group [firstConfigProductSelectSecondOptionValue] StorefrontProductPageSelectRadioButtonOptionValueActionGroup");
		$I->comment("Entering Action Group [addFirstConfigProductToCart] AddToCartFromStorefrontProductPageActionGroup");
		$I->click("#product-addtocart-button"); // stepKey: addToCartAddFirstConfigProductToCart
		$I->waitForPageLoad(60); // stepKey: addToCartAddFirstConfigProductToCartWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForAddToCartAddFirstConfigProductToCart
		$I->waitForElementNotVisible("//button/span[text()='Adding...']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddingAddFirstConfigProductToCart
		$I->waitForElementNotVisible("//button/span[text()='Added']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddedAddFirstConfigProductToCart
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAddFirstConfigProductToCart
		$I->waitForElementVisible("div.message-success.success.message", 30); // stepKey: waitForSuccessMessageAddFirstConfigProductToCart
		$I->see("You added " . $I->retrieveEntityField('createFirstConfigProduct', 'name', 'test') . " to your shopping cart.", "div.message-success.success.message"); // stepKey: seeAddToCartSuccessMessageAddFirstConfigProductToCart
		$I->comment("Exiting Action Group [addFirstConfigProductToCart] AddToCartFromStorefrontProductPageActionGroup");
		$I->comment("Add first product with another selected options to the cart");
		$I->comment("Entering Action Group [firstConfigProductSelectFirstOptionAnotherValue] StorefrontProductPageSelectDropDownOptionValueActionGroup");
		$I->selectOption("//*[@id='product-options-wrapper']//div[@class='fieldset']//label[contains(.,'" . $I->retrieveEntityField('createFirstConfigProductAttribute', 'default_frontend_label', 'test') . "')]/../div[@class='control']//select", $I->retrieveEntityField('createFirstConfigProductAttributeSecondOption', 'option[store_labels][1][label]', 'test')); // stepKey: fillDropDownAttributeOptionFirstConfigProductSelectFirstOptionAnotherValue
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadFirstConfigProductSelectFirstOptionAnotherValue
		$I->comment("Exiting Action Group [firstConfigProductSelectFirstOptionAnotherValue] StorefrontProductPageSelectDropDownOptionValueActionGroup");
		$I->comment("Entering Action Group [firstConfigProductSelectSecondOptionAnotherValue] StorefrontProductPageSelectRadioButtonOptionValueActionGroup");
		$I->checkOption("//*[@id='product-options-wrapper']//div[contains(@class,'fieldset')]//label[contains(.,'OptionRadioButtons')]/../div[contains(@class,'control')]//label[contains(@class,'label') and contains(.,'OptionValueRadioButtons3')]/preceding-sibling::input[@type='radio']"); // stepKey: fillRadioButtonAttributeOptionFirstConfigProductSelectSecondOptionAnotherValue
		$I->comment("Exiting Action Group [firstConfigProductSelectSecondOptionAnotherValue] StorefrontProductPageSelectRadioButtonOptionValueActionGroup");
		$I->comment("Entering Action Group [addFirstConfigProductWithOtherOptionsToCart] AddToCartFromStorefrontProductPageActionGroup");
		$I->click("#product-addtocart-button"); // stepKey: addToCartAddFirstConfigProductWithOtherOptionsToCart
		$I->waitForPageLoad(60); // stepKey: addToCartAddFirstConfigProductWithOtherOptionsToCartWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForAddToCartAddFirstConfigProductWithOtherOptionsToCart
		$I->waitForElementNotVisible("//button/span[text()='Adding...']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddingAddFirstConfigProductWithOtherOptionsToCart
		$I->waitForElementNotVisible("//button/span[text()='Added']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddedAddFirstConfigProductWithOtherOptionsToCart
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAddFirstConfigProductWithOtherOptionsToCart
		$I->waitForElementVisible("div.message-success.success.message", 30); // stepKey: waitForSuccessMessageAddFirstConfigProductWithOtherOptionsToCart
		$I->see("You added " . $I->retrieveEntityField('createFirstConfigProduct', 'name', 'test') . " to your shopping cart.", "div.message-success.success.message"); // stepKey: seeAddToCartSuccessMessageAddFirstConfigProductWithOtherOptionsToCart
		$I->comment("Exiting Action Group [addFirstConfigProductWithOtherOptionsToCart] AddToCartFromStorefrontProductPageActionGroup");
		$I->comment("Assert second product in storefront product page");
		$I->amOnPage("/" . $I->retrieveEntityField('createSecondConfigProduct', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: amOnSecondProductPage
		$I->waitForPageLoad(30); // stepKey: waitForSecondProductPageLoad
		$I->comment("Entering Action Group [checkSecondProductPriceInStorefrontProductPage] StorefrontAssertUpdatedProductPriceInStorefrontProductPageActionGroup");
		$I->seeInTitle($I->retrieveEntityField('createSecondConfigProduct', 'name', 'test')); // stepKey: assertProductNameTitleCheckSecondProductPriceInStorefrontProductPage
		$I->see($I->retrieveEntityField('createSecondConfigProduct', 'name', 'test'), ".base"); // stepKey: assertProductNameCheckSecondProductPriceInStorefrontProductPage
		$I->see("110.7", "div.price-box.price-final_price"); // stepKey: assertProductPriceCheckSecondProductPriceInStorefrontProductPage
		$I->comment("Exiting Action Group [checkSecondProductPriceInStorefrontProductPage] StorefrontAssertUpdatedProductPriceInStorefrontProductPageActionGroup");
		$I->comment("Add second product with selected options to the cart");
		$I->comment("Entering Action Group [secondConfigProductSelectFirstOptionValue] StorefrontProductPageSelectDropDownOptionValueActionGroup");
		$I->selectOption("//*[@id='product-options-wrapper']//div[@class='fieldset']//label[contains(.,'" . $I->retrieveEntityField('createSecondConfigProductAttribute', 'default_frontend_label', 'test') . "')]/../div[@class='control']//select", $I->retrieveEntityField('createSecondConfigProductAttributeFirstOption', 'option[store_labels][1][label]', 'test')); // stepKey: fillDropDownAttributeOptionSecondConfigProductSelectFirstOptionValue
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadSecondConfigProductSelectFirstOptionValue
		$I->comment("Exiting Action Group [secondConfigProductSelectFirstOptionValue] StorefrontProductPageSelectDropDownOptionValueActionGroup");
		$I->comment("Entering Action Group [secondConfigProductSelectSecondOptionValue] StorefrontProductPageSelectRadioButtonOptionValueActionGroup");
		$I->checkOption("//*[@id='product-options-wrapper']//div[contains(@class,'fieldset')]//label[contains(.,'OptionRadioButtons')]/../div[contains(@class,'control')]//label[contains(@class,'label') and contains(.,'OptionValueRadioButtons1')]/preceding-sibling::input[@type='radio']"); // stepKey: fillRadioButtonAttributeOptionSecondConfigProductSelectSecondOptionValue
		$I->comment("Exiting Action Group [secondConfigProductSelectSecondOptionValue] StorefrontProductPageSelectRadioButtonOptionValueActionGroup");
		$I->comment("Entering Action Group [addSecondConfigProductToCart] AddToCartFromStorefrontProductPageActionGroup");
		$I->click("#product-addtocart-button"); // stepKey: addToCartAddSecondConfigProductToCart
		$I->waitForPageLoad(60); // stepKey: addToCartAddSecondConfigProductToCartWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForAddToCartAddSecondConfigProductToCart
		$I->waitForElementNotVisible("//button/span[text()='Adding...']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddingAddSecondConfigProductToCart
		$I->waitForElementNotVisible("//button/span[text()='Added']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddedAddSecondConfigProductToCart
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAddSecondConfigProductToCart
		$I->waitForElementVisible("div.message-success.success.message", 30); // stepKey: waitForSuccessMessageAddSecondConfigProductToCart
		$I->see("You added " . $I->retrieveEntityField('createSecondConfigProduct', 'name', 'test') . " to your shopping cart.", "div.message-success.success.message"); // stepKey: seeAddToCartSuccessMessageAddSecondConfigProductToCart
		$I->comment("Exiting Action Group [addSecondConfigProductToCart] AddToCartFromStorefrontProductPageActionGroup");
		$I->comment("Add second product with another selected options to the cart");
		$I->comment("Entering Action Group [secondConfigProductSelectFirstOptionAnotherValue] StorefrontProductPageSelectDropDownOptionValueActionGroup");
		$I->selectOption("//*[@id='product-options-wrapper']//div[@class='fieldset']//label[contains(.,'" . $I->retrieveEntityField('createSecondConfigProductAttribute', 'default_frontend_label', 'test') . "')]/../div[@class='control']//select", $I->retrieveEntityField('createSecondConfigProductAttributeSecondOption', 'option[store_labels][1][label]', 'test')); // stepKey: fillDropDownAttributeOptionSecondConfigProductSelectFirstOptionAnotherValue
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadSecondConfigProductSelectFirstOptionAnotherValue
		$I->comment("Exiting Action Group [secondConfigProductSelectFirstOptionAnotherValue] StorefrontProductPageSelectDropDownOptionValueActionGroup");
		$I->comment("Entering Action Group [secondConfigProductSelectSecondOptionAnotherValue] StorefrontProductPageSelectRadioButtonOptionValueActionGroup");
		$I->checkOption("//*[@id='product-options-wrapper']//div[contains(@class,'fieldset')]//label[contains(.,'OptionRadioButtons')]/../div[contains(@class,'control')]//label[contains(@class,'label') and contains(.,'OptionValueRadioButtons3')]/preceding-sibling::input[@type='radio']"); // stepKey: fillRadioButtonAttributeOptionSecondConfigProductSelectSecondOptionAnotherValue
		$I->comment("Exiting Action Group [secondConfigProductSelectSecondOptionAnotherValue] StorefrontProductPageSelectRadioButtonOptionValueActionGroup");
		$I->comment("Entering Action Group [addSecondConfigProductWithOtherOptionsToCart] AddToCartFromStorefrontProductPageActionGroup");
		$I->click("#product-addtocart-button"); // stepKey: addToCartAddSecondConfigProductWithOtherOptionsToCart
		$I->waitForPageLoad(60); // stepKey: addToCartAddSecondConfigProductWithOtherOptionsToCartWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForAddToCartAddSecondConfigProductWithOtherOptionsToCart
		$I->waitForElementNotVisible("//button/span[text()='Adding...']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddingAddSecondConfigProductWithOtherOptionsToCart
		$I->waitForElementNotVisible("//button/span[text()='Added']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddedAddSecondConfigProductWithOtherOptionsToCart
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAddSecondConfigProductWithOtherOptionsToCart
		$I->waitForElementVisible("div.message-success.success.message", 30); // stepKey: waitForSuccessMessageAddSecondConfigProductWithOtherOptionsToCart
		$I->see("You added " . $I->retrieveEntityField('createSecondConfigProduct', 'name', 'test') . " to your shopping cart.", "div.message-success.success.message"); // stepKey: seeAddToCartSuccessMessageAddSecondConfigProductWithOtherOptionsToCart
		$I->comment("Exiting Action Group [addSecondConfigProductWithOtherOptionsToCart] AddToCartFromStorefrontProductPageActionGroup");
		$I->comment("Assert products prices in the cart");
		$I->comment("Entering Action Group [amOnShoppingCartPage] StorefrontOpenCartFromMinicartActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollToTopOfThePageAmOnShoppingCartPage
		$I->waitForElement("a.showcart", 30); // stepKey: waitForShowMinicartAmOnShoppingCartPage
		$I->waitForPageLoad(60); // stepKey: waitForShowMinicartAmOnShoppingCartPageWaitForPageLoad
		$I->waitForElement(".action.viewcart", 30); // stepKey: waitForCartLinkAmOnShoppingCartPage
		$I->waitForPageLoad(30); // stepKey: waitForCartLinkAmOnShoppingCartPageWaitForPageLoad
		$I->click("a.showcart"); // stepKey: clickShowMinicartAmOnShoppingCartPage
		$I->waitForPageLoad(60); // stepKey: clickShowMinicartAmOnShoppingCartPageWaitForPageLoad
		$I->click(".action.viewcart"); // stepKey: clickCartAmOnShoppingCartPage
		$I->waitForPageLoad(30); // stepKey: clickCartAmOnShoppingCartPageWaitForPageLoad
		$I->comment("Exiting Action Group [amOnShoppingCartPage] StorefrontOpenCartFromMinicartActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForShoppingCartPageLoad
		$I->waitForElementVisible("//*[contains(@class, 'item-options')]/dd[normalize-space(.)='" . $I->retrieveEntityField('createFirstConfigProductAttributeFirstOption', 'option[store_labels][1][label]', 'test') . "']/ancestor::tr//td[contains(@class, 'price')]//span[@class='price']", 30); // stepKey: waitForCartFullyLoaded
		$I->see("$210.69", "//*[contains(@class, 'item-options')]/dd[normalize-space(.)='" . $I->retrieveEntityField('createFirstConfigProductAttributeFirstOption', 'option[store_labels][1][label]', 'test') . "']/ancestor::tr//td[contains(@class, 'price')]//span[@class='price']"); // stepKey: assertFirstProductPriceForFirstProductOption
		$I->see("$120.70", "//*[contains(@class, 'item-options')]/dd[normalize-space(.)='" . $I->retrieveEntityField('createFirstConfigProductAttributeSecondOption', 'option[store_labels][1][label]', 'test') . "']/ancestor::tr//td[contains(@class, 'price')]//span[@class='price']"); // stepKey: assertFirstProductPriceForSecondProductOption
		$I->see("$210.69", "//*[contains(@class, 'item-options')]/dd[normalize-space(.)='" . $I->retrieveEntityField('createSecondConfigProductAttributeFirstOption', 'option[store_labels][1][label]', 'test') . "']/ancestor::tr//td[contains(@class, 'price')]//span[@class='price']"); // stepKey: assertSecondProductPriceForFirstProductOption
		$I->see("$120.70", "//*[contains(@class, 'item-options')]/dd[normalize-space(.)='" . $I->retrieveEntityField('createSecondConfigProductAttributeSecondOption', 'option[store_labels][1][label]', 'test') . "']/ancestor::tr//td[contains(@class, 'price')]//span[@class='price']"); // stepKey: assertSecondProductPriceForSecondProductOption
	}
}
