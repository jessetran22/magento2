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
 * @Title("MC-28345: Admin should be able to apply the catalog price rule for simple product with 3 custom options")
 * @Description("Admin should be able to apply the catalog price rule for simple product with 3 custom options<h3>Test files</h3>app/code/Magento/CatalogRule/Test/Mftf/Test/StorefrontApplyCatalogRuleForSimpleProductsWithCustomOptionsTest.xml<br>")
 * @TestCaseId("MC-28345")
 * @group catalogRule
 * @group mtf_migrated
 * @group catalog
 */
class StorefrontApplyCatalogRuleForSimpleProductsWithCustomOptionsTestCest
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
		$I->createEntity("createCategory", "hook", "_defaultCategory", [], []); // stepKey: createCategory
		$createProduct1Fields['price'] = "56.78";
		$I->createEntity("createProduct1", "hook", "_defaultProduct", ["createCategory"], $createProduct1Fields); // stepKey: createProduct1
		$createProduct2Fields['price'] = "56.78";
		$I->createEntity("createProduct2", "hook", "_defaultProduct", ["createCategory"], $createProduct2Fields); // stepKey: createProduct2
		$createProduct3Fields['price'] = "56.78";
		$I->createEntity("createProduct3", "hook", "_defaultProduct", ["createCategory"], $createProduct3Fields); // stepKey: createProduct3
		$I->comment("Update all products to have custom options");
		$I->updateEntity("createProduct1", "hook", "productWithCustomOptions",[]); // stepKey: updateProduc1tWithOptions
		$I->updateEntity("createProduct2", "hook", "productWithCustomOptions",[]); // stepKey: updateProduct2WithOptions
		$I->updateEntity("createProduct3", "hook", "productWithCustomOptions",[]); // stepKey: updateProduct3WithOptions
		$I->comment("Login as Admin");
		$I->comment("Entering Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsAdmin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginAsAdmin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginAsAdmin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsAdmin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsAdminWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsAdmin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsAdmin
		$I->comment("Exiting Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->comment("Clear all catalog price rules before test");
		$I->comment("Entering Action Group [deleteAllCatalogRulesBeforeTest] AdminCatalogPriceRuleDeleteAllActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog_rule/promo_catalog/"); // stepKey: goToAdminCatalogPriceRuleGridPageDeleteAllCatalogRulesBeforeTest
		$I->comment("It sometimes is loading too long for default 10s");
		$I->waitForPageLoad(60); // stepKey: waitForPageFullyLoadedDeleteAllCatalogRulesBeforeTest
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clearExistingFiltersDeleteAllCatalogRulesBeforeTest
		$I->waitForPageLoad(30); // stepKey: clearExistingFiltersDeleteAllCatalogRulesBeforeTestWaitForPageLoad
		$I->comment('[deleteAllRulesOneByOneDeleteAllCatalogRulesBeforeTest] Magento\Rule\Test\Mftf\Helper\RuleHelper::deleteAllRulesOneByOne()');
		$this->helperContainer->get('Magento\Rule\Test\Mftf\Helper\RuleHelper')->deleteAllRulesOneByOne("table.data-grid tbody tr[data-role=row]:not(.data-grid-tr-no-data):nth-of-type(1)", "aside.confirm .modal-footer button.action-accept", "#delete", "#messages div.message-success", "You deleted the rule."); // stepKey: deleteAllRulesOneByOneDeleteAllCatalogRulesBeforeTest
		$I->waitForElementVisible(".data-grid-tr-no-data td", 30); // stepKey: waitDataGridEmptyMessageAppearsDeleteAllCatalogRulesBeforeTest
		$I->see("We couldn't find any records.", ".data-grid-tr-no-data td"); // stepKey: assertDataGridEmptyMessageDeleteAllCatalogRulesBeforeTest
		$I->comment("Exiting Action Group [deleteAllCatalogRulesBeforeTest] AdminCatalogPriceRuleDeleteAllActionGroup");
		$fixInvalidatedIndicesBeforeTest = $I->magentoCron("index", 90); // stepKey: fixInvalidatedIndicesBeforeTest
		$I->comment($fixInvalidatedIndicesBeforeTest);
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Delete products and category");
		$I->deleteEntity("createProduct1", "hook"); // stepKey: deleteProduct1
		$I->deleteEntity("createProduct2", "hook"); // stepKey: deleteProduct2
		$I->deleteEntity("createProduct3", "hook"); // stepKey: deleteProduct3
		$I->deleteEntity("createCategory", "hook"); // stepKey: deleteCategory
		$I->comment("Delete the catalog price rule");
		$I->comment("Entering Action Group [deleteAllCatalogRulesAfterTest] AdminCatalogPriceRuleDeleteAllActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog_rule/promo_catalog/"); // stepKey: goToAdminCatalogPriceRuleGridPageDeleteAllCatalogRulesAfterTest
		$I->comment("It sometimes is loading too long for default 10s");
		$I->waitForPageLoad(60); // stepKey: waitForPageFullyLoadedDeleteAllCatalogRulesAfterTest
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clearExistingFiltersDeleteAllCatalogRulesAfterTest
		$I->waitForPageLoad(30); // stepKey: clearExistingFiltersDeleteAllCatalogRulesAfterTestWaitForPageLoad
		$I->comment('[deleteAllRulesOneByOneDeleteAllCatalogRulesAfterTest] Magento\Rule\Test\Mftf\Helper\RuleHelper::deleteAllRulesOneByOne()');
		$this->helperContainer->get('Magento\Rule\Test\Mftf\Helper\RuleHelper')->deleteAllRulesOneByOne("table.data-grid tbody tr[data-role=row]:not(.data-grid-tr-no-data):nth-of-type(1)", "aside.confirm .modal-footer button.action-accept", "#delete", "#messages div.message-success", "You deleted the rule."); // stepKey: deleteAllRulesOneByOneDeleteAllCatalogRulesAfterTest
		$I->waitForElementVisible(".data-grid-tr-no-data td", 30); // stepKey: waitDataGridEmptyMessageAppearsDeleteAllCatalogRulesAfterTest
		$I->see("We couldn't find any records.", ".data-grid-tr-no-data td"); // stepKey: assertDataGridEmptyMessageDeleteAllCatalogRulesAfterTest
		$I->comment("Exiting Action Group [deleteAllCatalogRulesAfterTest] AdminCatalogPriceRuleDeleteAllActionGroup");
		$fixInvalidatedIndicesAfterTest = $I->magentoCron("index", 90); // stepKey: fixInvalidatedIndicesAfterTest
		$I->comment($fixInvalidatedIndicesAfterTest);
		$I->comment("Logout");
		$I->comment("Entering Action Group [logoutFromAdmin] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageLogoutFromAdmin
		$I->comment("Exiting Action Group [logoutFromAdmin] AdminLogoutActionGroup");
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
	 * @Stories({"Apply catalog price rule"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function StorefrontApplyCatalogRuleForSimpleProductsWithCustomOptionsTest(AcceptanceTester $I)
	{
		$I->comment("1. Begin creating a new catalog price rule");
		$I->comment("Entering Action Group [openNewCatalogPriceRulePage] AdminOpenNewCatalogPriceRuleFormPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog_rule/promo_catalog/new/"); // stepKey: openNewCatalogPriceRulePageOpenNewCatalogPriceRulePage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadOpenNewCatalogPriceRulePage
		$I->comment("Exiting Action Group [openNewCatalogPriceRulePage] AdminOpenNewCatalogPriceRuleFormPageActionGroup");
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
		$I->comment("Entering Action Group [fillConditionsForCatalogPriceRule] AdminFillCatalogRuleConditionActionGroup");
		$I->conditionalClick("[data-index='block_promo_catalog_edit_tab_conditions']", ".rule-param.rule-param-new-child", false); // stepKey: openConditionsTabFillConditionsForCatalogPriceRule
		$I->waitForPageLoad(30); // stepKey: openConditionsTabFillConditionsForCatalogPriceRuleWaitForPageLoad
		$I->waitForElementVisible(".rule-param.rule-param-new-child", 30); // stepKey: waitForAddConditionButtonFillConditionsForCatalogPriceRule
		$I->waitForPageLoad(30); // stepKey: waitForAddConditionButtonFillConditionsForCatalogPriceRuleWaitForPageLoad
		$I->click(".rule-param.rule-param-new-child"); // stepKey: addNewConditionFillConditionsForCatalogPriceRule
		$I->waitForPageLoad(30); // stepKey: addNewConditionFillConditionsForCatalogPriceRuleWaitForPageLoad
		$I->selectOption("select#conditions__1__new_child", "Magento\CatalogRule\Model\Rule\Condition\Product|category_ids"); // stepKey: selectTypeConditionFillConditionsForCatalogPriceRule
		$I->waitForPageLoad(30); // stepKey: selectTypeConditionFillConditionsForCatalogPriceRuleWaitForPageLoad
		$I->click("//span[@class='rule-param']/a[text()='is']"); // stepKey: clickOnOperatorFillConditionsForCatalogPriceRule
		$I->selectOption(".rule-param-edit select[name*='[operator]']", "is"); // stepKey: selectConditionFillConditionsForCatalogPriceRule
		$I->comment("In case we are choosing already selected value - select is not closed automatically");
		$I->conditionalClick("//span[@class='rule-param']/a[text()='...']", ".rule-param-edit select[name*='[operator]']", true); // stepKey: closeSelectFillConditionsForCatalogPriceRule
		$I->click("//span[@class='rule-param']/a[text()='...']"); // stepKey: clickToChooseOption3FillConditionsForCatalogPriceRule
		$I->waitForElementVisible(".rule-param-edit [name*='[value]']", 30); // stepKey: waitForValueInputFillConditionsForCatalogPriceRule
		$I->fillField(".rule-param-edit [name*='[value]']", $I->retrieveEntityField('createCategory', 'id', 'test')); // stepKey: fillConditionValueFillConditionsForCatalogPriceRule
		$I->click(".rule-param-edit .rule-param-apply"); // stepKey: clickApplyFillConditionsForCatalogPriceRule
		$I->waitForPageLoad(30); // stepKey: clickApplyFillConditionsForCatalogPriceRuleWaitForPageLoad
		$I->waitForElementNotVisible(".rule-param-edit .rule-param-apply", 30); // stepKey: waitForApplyButtonInvisibilityFillConditionsForCatalogPriceRule
		$I->waitForPageLoad(30); // stepKey: waitForApplyButtonInvisibilityFillConditionsForCatalogPriceRuleWaitForPageLoad
		$I->comment("Exiting Action Group [fillConditionsForCatalogPriceRule] AdminFillCatalogRuleConditionActionGroup");
		$I->comment("Entering Action Group [fillActionsForCatalogPriceRule] AdminCatalogPriceRuleFillActionsActionGroup");
		$I->conditionalClick("[data-index='actions'] .fieldset-wrapper-title", "[data-index='actions'] .admin__fieldset-wrapper-content", false); // stepKey: openActionSectionIfNeededFillActionsForCatalogPriceRule
		$I->scrollTo("[data-index='actions'] .fieldset-wrapper-title"); // stepKey: scrollToActionsFieldsetFillActionsForCatalogPriceRule
		$I->waitForElementVisible("[name='simple_action']", 30); // stepKey: waitActionsFieldsetFullyOpenedFillActionsForCatalogPriceRule
		$I->selectOption("[name='simple_action']", "by_percent"); // stepKey: fillDiscountTypeFillActionsForCatalogPriceRule
		$I->fillField("[name='discount_amount']", "10"); // stepKey: fillDiscountAmountFillActionsForCatalogPriceRule
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
		$I->comment("Navigate to category on store front");
		$I->comment("Entering Action Group [goToStorefrontCategoryPage] StorefrontNavigateCategoryPageActionGroup");
		$I->comment("Open category page on storefront");
		$I->amOnPage("/" . $I->retrieveEntityField('createCategory', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: navigateStorefrontCategoryPageGoToStorefrontCategoryPage
		$I->waitForPageLoad(30); // stepKey: waitForCategoryPageLoadGoToStorefrontCategoryPage
		$I->comment("Exiting Action Group [goToStorefrontCategoryPage] StorefrontNavigateCategoryPageActionGroup");
		$I->comment("Check product 1 price on store front category page");
		$I->comment("Entering Action Group [assertStorefrontProduct1Price] StorefrontAssertProductPriceOnCategoryPageActionGroup");
		$I->see("$51.10", "//main//li[.//a[contains(text(), '" . $I->retrieveEntityField('createProduct1', 'name', 'test') . "')]]//span[@class='price']"); // stepKey: seeProductPriceAssertStorefrontProduct1Price
		$I->comment("Exiting Action Group [assertStorefrontProduct1Price] StorefrontAssertProductPriceOnCategoryPageActionGroup");
		$I->comment("Check product 1 regular price on store front category page");
		$I->comment("Entering Action Group [assertStorefrontProduct1RegularPrice] StorefrontAssertProductPriceOnCategoryPageActionGroup");
		$I->see("$56.78", "//main//li[.//a[contains(text(), '" . $I->retrieveEntityField('createProduct1', 'name', 'test') . "')]]//span[@class='price']"); // stepKey: seeProductPriceAssertStorefrontProduct1RegularPrice
		$I->comment("Exiting Action Group [assertStorefrontProduct1RegularPrice] StorefrontAssertProductPriceOnCategoryPageActionGroup");
		$I->comment("Check product 2 price on store front category page");
		$I->comment("Entering Action Group [assertStorefrontProduct2Price] StorefrontAssertProductPriceOnCategoryPageActionGroup");
		$I->see("$51.10", "//main//li[.//a[contains(text(), '" . $I->retrieveEntityField('createProduct2', 'name', 'test') . "')]]//span[@class='price']"); // stepKey: seeProductPriceAssertStorefrontProduct2Price
		$I->comment("Exiting Action Group [assertStorefrontProduct2Price] StorefrontAssertProductPriceOnCategoryPageActionGroup");
		$I->comment("Check product 2 regular price on store front category page");
		$I->comment("Entering Action Group [assertStorefrontProduct2RegularPrice] StorefrontAssertProductPriceOnCategoryPageActionGroup");
		$I->see("$56.78", "//main//li[.//a[contains(text(), '" . $I->retrieveEntityField('createProduct2', 'name', 'test') . "')]]//span[@class='price']"); // stepKey: seeProductPriceAssertStorefrontProduct2RegularPrice
		$I->comment("Exiting Action Group [assertStorefrontProduct2RegularPrice] StorefrontAssertProductPriceOnCategoryPageActionGroup");
		$I->comment("Check product 3 price on store front category page");
		$I->comment("Entering Action Group [assertStorefrontProduct3Price] StorefrontAssertProductPriceOnCategoryPageActionGroup");
		$I->see("$51.10", "//main//li[.//a[contains(text(), '" . $I->retrieveEntityField('createProduct3', 'name', 'test') . "')]]//span[@class='price']"); // stepKey: seeProductPriceAssertStorefrontProduct3Price
		$I->comment("Exiting Action Group [assertStorefrontProduct3Price] StorefrontAssertProductPriceOnCategoryPageActionGroup");
		$I->comment("Check product 3 regular price on store front category page");
		$I->comment("Entering Action Group [assertStorefrontProduct3RegularPrice] StorefrontAssertProductPriceOnCategoryPageActionGroup");
		$I->see("$56.78", "//main//li[.//a[contains(text(), '" . $I->retrieveEntityField('createProduct3', 'name', 'test') . "')]]//span[@class='price']"); // stepKey: seeProductPriceAssertStorefrontProduct3RegularPrice
		$I->comment("Exiting Action Group [assertStorefrontProduct3RegularPrice] StorefrontAssertProductPriceOnCategoryPageActionGroup");
		$I->comment("Navigate to product 1 on store front");
		$I->comment("Entering Action Group [goToProduct1Page] OpenStoreFrontProductPageActionGroup");
		$I->amOnPage("/" . $I->retrieveEntityField('createProduct1', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: amOnProductPageGoToProduct1Page
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoadGoToProduct1Page
		$I->comment("Exiting Action Group [goToProduct1Page] OpenStoreFrontProductPageActionGroup");
		$I->comment("Assert regular and special price for product 1 after selecting ProductOptionValueDropdown1");
		$I->comment("Entering Action Group [storefrontSelectCustomOptionAndAssertProduct1Prices] StorefrontSelectCustomOptionDropDownAndAssertPricesActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForStorefrontProductPageLoadStorefrontSelectCustomOptionAndAssertProduct1Prices
		$I->selectOption("//*[@id='product-options-wrapper']//select[contains(@class, 'product-custom-option admin__control-select')]", "OptionValueDropDown1 +$0.01"); // stepKey: selectCustomOptionStorefrontSelectCustomOptionAndAssertProduct1Prices
		$I->see("$56.79", "div.price-box.price-final_price"); // stepKey: productPriceAmountStorefrontSelectCustomOptionAndAssertProduct1Prices
		$I->see("$51.11", "div.price-box.price-final_price [data-price-type='finalPrice'] .price"); // stepKey: productFinalPriceAmountStorefrontSelectCustomOptionAndAssertProduct1Prices
		$I->comment("Exiting Action Group [storefrontSelectCustomOptionAndAssertProduct1Prices] StorefrontSelectCustomOptionDropDownAndAssertPricesActionGroup");
		$I->comment("Add product 1 to cart");
		$I->comment("Entering Action Group [addToCartFromStorefrontProduct1Page] AddToCartFromStorefrontProductPageActionGroup");
		$I->click("#product-addtocart-button"); // stepKey: addToCartAddToCartFromStorefrontProduct1Page
		$I->waitForPageLoad(60); // stepKey: addToCartAddToCartFromStorefrontProduct1PageWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForAddToCartAddToCartFromStorefrontProduct1Page
		$I->waitForElementNotVisible("//button/span[text()='Adding...']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddingAddToCartFromStorefrontProduct1Page
		$I->waitForElementNotVisible("//button/span[text()='Added']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddedAddToCartFromStorefrontProduct1Page
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAddToCartFromStorefrontProduct1Page
		$I->waitForElementVisible("div.message-success.success.message", 30); // stepKey: waitForSuccessMessageAddToCartFromStorefrontProduct1Page
		$I->see("You added " . $I->retrieveEntityField('createProduct1', 'name', 'test') . " to your shopping cart.", "div.message-success.success.message"); // stepKey: seeAddToCartSuccessMessageAddToCartFromStorefrontProduct1Page
		$I->comment("Exiting Action Group [addToCartFromStorefrontProduct1Page] AddToCartFromStorefrontProductPageActionGroup");
		$I->comment("Navigate to product 2 on store front");
		$I->comment("Entering Action Group [goToProduct2Page] OpenStoreFrontProductPageActionGroup");
		$I->amOnPage("/" . $I->retrieveEntityField('createProduct2', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: amOnProductPageGoToProduct2Page
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoadGoToProduct2Page
		$I->comment("Exiting Action Group [goToProduct2Page] OpenStoreFrontProductPageActionGroup");
		$I->comment("Assert regular and special price for product 2 after selecting ProductOptionValueDropdown3");
		$I->comment("Entering Action Group [storefrontSelectCustomOptionAndAssertProduct2Prices] StorefrontSelectCustomOptionDropDownAndAssertPricesActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForStorefrontProductPageLoadStorefrontSelectCustomOptionAndAssertProduct2Prices
		$I->selectOption("//*[@id='product-options-wrapper']//select[contains(@class, 'product-custom-option admin__control-select')]", "OptionValueDropDown3 +$5.11"); // stepKey: selectCustomOptionStorefrontSelectCustomOptionAndAssertProduct2Prices
		$I->see("$62.46", "div.price-box.price-final_price"); // stepKey: productPriceAmountStorefrontSelectCustomOptionAndAssertProduct2Prices
		$I->see("$56.21", "div.price-box.price-final_price [data-price-type='finalPrice'] .price"); // stepKey: productFinalPriceAmountStorefrontSelectCustomOptionAndAssertProduct2Prices
		$I->comment("Exiting Action Group [storefrontSelectCustomOptionAndAssertProduct2Prices] StorefrontSelectCustomOptionDropDownAndAssertPricesActionGroup");
		$I->comment("Add product 2 to cart");
		$I->comment("Entering Action Group [addToCartFromStorefrontProduct2Page] AddToCartFromStorefrontProductPageActionGroup");
		$I->click("#product-addtocart-button"); // stepKey: addToCartAddToCartFromStorefrontProduct2Page
		$I->waitForPageLoad(60); // stepKey: addToCartAddToCartFromStorefrontProduct2PageWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForAddToCartAddToCartFromStorefrontProduct2Page
		$I->waitForElementNotVisible("//button/span[text()='Adding...']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddingAddToCartFromStorefrontProduct2Page
		$I->waitForElementNotVisible("//button/span[text()='Added']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddedAddToCartFromStorefrontProduct2Page
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAddToCartFromStorefrontProduct2Page
		$I->waitForElementVisible("div.message-success.success.message", 30); // stepKey: waitForSuccessMessageAddToCartFromStorefrontProduct2Page
		$I->see("You added " . $I->retrieveEntityField('createProduct2', 'name', 'test') . " to your shopping cart.", "div.message-success.success.message"); // stepKey: seeAddToCartSuccessMessageAddToCartFromStorefrontProduct2Page
		$I->comment("Exiting Action Group [addToCartFromStorefrontProduct2Page] AddToCartFromStorefrontProductPageActionGroup");
		$I->comment("Navigate to product 3 on store front");
		$I->comment("Entering Action Group [goToProduct3Page] OpenStoreFrontProductPageActionGroup");
		$I->amOnPage("/" . $I->retrieveEntityField('createProduct3', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: amOnProductPageGoToProduct3Page
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoadGoToProduct3Page
		$I->comment("Exiting Action Group [goToProduct3Page] OpenStoreFrontProductPageActionGroup");
		$I->comment("Add product 3 to cart with no custom option");
		$I->comment("Entering Action Group [addToCartFromStorefrontProduct3Page] AddToCartFromStorefrontProductPageActionGroup");
		$I->click("#product-addtocart-button"); // stepKey: addToCartAddToCartFromStorefrontProduct3Page
		$I->waitForPageLoad(60); // stepKey: addToCartAddToCartFromStorefrontProduct3PageWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForAddToCartAddToCartFromStorefrontProduct3Page
		$I->waitForElementNotVisible("//button/span[text()='Adding...']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddingAddToCartFromStorefrontProduct3Page
		$I->waitForElementNotVisible("//button/span[text()='Added']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddedAddToCartFromStorefrontProduct3Page
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAddToCartFromStorefrontProduct3Page
		$I->waitForElementVisible("div.message-success.success.message", 30); // stepKey: waitForSuccessMessageAddToCartFromStorefrontProduct3Page
		$I->see("You added " . $I->retrieveEntityField('createProduct3', 'name', 'test') . " to your shopping cart.", "div.message-success.success.message"); // stepKey: seeAddToCartSuccessMessageAddToCartFromStorefrontProduct3Page
		$I->comment("Exiting Action Group [addToCartFromStorefrontProduct3Page] AddToCartFromStorefrontProductPageActionGroup");
		$I->comment("Assert subtotal on mini shopping cart");
		$I->comment("Entering Action Group [assertSubTotalOnStorefrontMiniCart] AssertSubTotalOnStorefrontMiniCartActionGroup");
		$I->waitForElementVisible("a.showcart", 30); // stepKey: waitForShowCartButtonVisibleAssertSubTotalOnStorefrontMiniCart
		$I->waitForPageLoad(60); // stepKey: waitForShowCartButtonVisibleAssertSubTotalOnStorefrontMiniCartWaitForPageLoad
		$I->click("a.showcart"); // stepKey: clickOnMiniCartAssertSubTotalOnStorefrontMiniCart
		$I->waitForPageLoad(60); // stepKey: clickOnMiniCartAssertSubTotalOnStorefrontMiniCartWaitForPageLoad
		$grabTextFromMiniCartSubtotalFieldAssertSubTotalOnStorefrontMiniCart = $I->grabTextFrom(".block-minicart .amount span.price"); // stepKey: grabTextFromMiniCartSubtotalFieldAssertSubTotalOnStorefrontMiniCart
		$I->assertEquals("$158.42", $grabTextFromMiniCartSubtotalFieldAssertSubTotalOnStorefrontMiniCart, "Mini shopping cart should contain subtotal $158.42"); // stepKey: assertSubtotalFieldFromMiniShoppingCart1AssertSubTotalOnStorefrontMiniCart
		$I->comment("Exiting Action Group [assertSubTotalOnStorefrontMiniCart] AssertSubTotalOnStorefrontMiniCartActionGroup");
		$I->comment("Navigate to checkout shipping page");
		$I->comment("Entering Action Group [onCheckout] OpenStoreFrontCheckoutShippingPageActionGroup");
		$I->amOnPage("/checkout/#shipping"); // stepKey: amOnCheckoutShippingPageOnCheckout
		$I->waitForPageLoad(30); // stepKey: waitForCheckoutShippingPageLoadOnCheckout
		$I->comment("Exiting Action Group [onCheckout] OpenStoreFrontCheckoutShippingPageActionGroup");
		$I->comment("Fill Shipping information");
		$I->comment("Entering Action Group [fillOrderShippingInfo] GuestCheckoutFillingShippingSectionActionGroup");
		$I->waitForElementVisible("input[id*=customer-email]", 30); // stepKey: waitForEmailFieldFillOrderShippingInfo
		$I->fillField("input[id*=customer-email]", msq("Simple_US_Customer") . "John.Doe@example.com"); // stepKey: enterEmailFillOrderShippingInfo
		$I->fillField("input[name=firstname]", "John"); // stepKey: enterFirstNameFillOrderShippingInfo
		$I->fillField("input[name=lastname]", "Doe"); // stepKey: enterLastNameFillOrderShippingInfo
		$I->fillField("input[name='street[0]']", "7700 West Parmer Lane"); // stepKey: enterStreetFillOrderShippingInfo
		$I->fillField("input[name=city]", "Austin"); // stepKey: enterCityFillOrderShippingInfo
		$I->selectOption("select[name=region_id]", "Texas"); // stepKey: selectRegionFillOrderShippingInfo
		$I->fillField("input[name=postcode]", "78729"); // stepKey: enterPostcodeFillOrderShippingInfo
		$I->fillField("input[name=telephone]", "512-345-6789"); // stepKey: enterTelephoneFillOrderShippingInfo
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskFillOrderShippingInfo
		$I->waitForElement("//div[@id='checkout-shipping-method-load']//td[contains(., '')]/..//input", 30); // stepKey: waitForShippingMethodFillOrderShippingInfo
		$I->click("//div[@id='checkout-shipping-method-load']//td[contains(., '')]/..//input"); // stepKey: selectShippingMethodFillOrderShippingInfo
		$I->waitForElement("button.button.action.continue.primary", 30); // stepKey: waitForNextButtonFillOrderShippingInfo
		$I->waitForPageLoad(30); // stepKey: waitForNextButtonFillOrderShippingInfoWaitForPageLoad
		$I->click("button.button.action.continue.primary"); // stepKey: clickNextFillOrderShippingInfo
		$I->waitForPageLoad(30); // stepKey: clickNextFillOrderShippingInfoWaitForPageLoad
		$I->waitForElement("//*[@id='checkout-payment-method-load']//div[@data-role='title']", 30); // stepKey: waitForPaymentSectionLoadedFillOrderShippingInfo
		$I->seeInCurrentUrl("/checkout/#payment"); // stepKey: assertCheckoutPaymentUrlFillOrderShippingInfo
		$I->comment("Exiting Action Group [fillOrderShippingInfo] GuestCheckoutFillingShippingSectionActionGroup");
		$I->comment("Verify order summary on payment page");
		$I->comment("Entering Action Group [verifyCheckoutPaymentOrderSummaryActionGroup] VerifyCheckoutPaymentOrderSummaryActionGroup");
		$I->see("$158.42", "//tr[@class='totals sub']//span[@class='price']"); // stepKey: seeCorrectSubtotalVerifyCheckoutPaymentOrderSummaryActionGroup
		$I->see("$15.00", "//tr[@class='totals shipping excl']//span[@class='price']"); // stepKey: seeCorrectShippingVerifyCheckoutPaymentOrderSummaryActionGroup
		$I->see("$173.42", "//tr[@class='grand totals']//span[@class='price']"); // stepKey: seeCorrectOrderTotalVerifyCheckoutPaymentOrderSummaryActionGroup
		$I->comment("Exiting Action Group [verifyCheckoutPaymentOrderSummaryActionGroup] VerifyCheckoutPaymentOrderSummaryActionGroup");
	}
}
