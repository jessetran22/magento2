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
 * @Title("MC-28347: Admin should be able to apply the catalog price rule for simple product with custom options")
 * @Description("Admin should be able to apply the catalog price rule for simple product with custom options<h3>Test files</h3>app/code/Magento/CatalogRule/Test/Mftf/Test/StorefrontApplyCatalogRuleForSimpleProductWithSelectFixedMethodTest.xml<br>")
 * @TestCaseId("MC-28347")
 * @group catalogRule
 * @group mtf_migrated
 * @group catalog
 */
class StorefrontApplyCatalogRuleForSimpleProductWithSelectFixedMethodTestCest
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
		$I->createEntity("createCategory", "hook", "_defaultCategory", [], []); // stepKey: createCategory
		$I->comment("Create Simple Product");
		$createProductFields['price'] = "56.78";
		$I->createEntity("createProduct", "hook", "_defaultProduct", ["createCategory"], $createProductFields); // stepKey: createProduct
		$I->comment("Update all products to have custom options");
		$I->updateEntity("createProduct", "hook", "productWithFixedOptions",[]); // stepKey: updateProductWithOptions
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
		$I->comment("Clear all catalog price rules and reindex before test");
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
		$I->deleteEntity("createProduct", "hook"); // stepKey: deleteProduct
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
		$fixInvalidatedIndicesAfter = $I->magentoCron("index", 90); // stepKey: fixInvalidatedIndicesAfter
		$I->comment($fixInvalidatedIndicesAfter);
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
	public function StorefrontApplyCatalogRuleForSimpleProductWithSelectFixedMethodTest(AcceptanceTester $I)
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
		$I->selectOption("[name='simple_action']", "by_fixed"); // stepKey: fillDiscountTypeFillActionsForCatalogPriceRule
		$I->fillField("[name='discount_amount']", "12.3"); // stepKey: fillDiscountAmountFillActionsForCatalogPriceRule
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
		$I->comment("Check product name on store front category page");
		$I->comment("Entering Action Group [assertStorefrontProductName] AssertProductDetailsOnStorefrontActionGroup");
		$I->see($I->retrieveEntityField('createProduct', 'name', 'test'), "//main//li[1]//div[@class='product-item-info']"); // stepKey: seeProductInfoAssertStorefrontProductName
		$I->comment("Exiting Action Group [assertStorefrontProductName] AssertProductDetailsOnStorefrontActionGroup");
		$I->comment("Check product price on store front category page");
		$I->comment("Entering Action Group [assertStorefrontProductPrice] AssertProductDetailsOnStorefrontActionGroup");
		$I->see("$44.48", "//main//li[1]//div[@class='product-item-info']"); // stepKey: seeProductInfoAssertStorefrontProductPrice
		$I->comment("Exiting Action Group [assertStorefrontProductPrice] AssertProductDetailsOnStorefrontActionGroup");
		$I->comment("Check product regular price on store front category page");
		$I->comment("Entering Action Group [assertStorefrontProductRegularPrice] AssertProductDetailsOnStorefrontActionGroup");
		$I->see("$56.78", "//main//li[1]//div[@class='product-item-info']"); // stepKey: seeProductInfoAssertStorefrontProductRegularPrice
		$I->comment("Exiting Action Group [assertStorefrontProductRegularPrice] AssertProductDetailsOnStorefrontActionGroup");
		$I->comment("Navigate to product on store front");
		$I->comment("Entering Action Group [goToProductPage] OpenStoreFrontProductPageActionGroup");
		$I->amOnPage("/" . $I->retrieveEntityField('createProduct', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: amOnProductPageGoToProductPage
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoadGoToProductPage
		$I->comment("Exiting Action Group [goToProductPage] OpenStoreFrontProductPageActionGroup");
		$I->comment("Assert regular and special price after selecting ProductOptionValueDropdown1");
		$I->comment("Entering Action Group [storefrontSelectCustomOptionAndAssertPrices] StorefrontSelectCustomOptionRadioAndAssertPricesActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForStorefrontProductPageLoadStorefrontSelectCustomOptionAndAssertPrices
		$I->click("//label[contains(.,'OptionRadioButtons')]/../div[@class='control']//span[@data-price-amount='99.99']"); // stepKey: clickRadioButtonsProductOptionStorefrontSelectCustomOptionAndAssertPrices
		$I->see("$156.77", "div.price-box.price-final_price"); // stepKey: productPriceAmountStorefrontSelectCustomOptionAndAssertPrices
		$I->see("$144.47", "div.price-box.price-final_price [data-price-type='finalPrice'] .price"); // stepKey: productFinalPriceAmountStorefrontSelectCustomOptionAndAssertPrices
		$I->comment("Exiting Action Group [storefrontSelectCustomOptionAndAssertPrices] StorefrontSelectCustomOptionRadioAndAssertPricesActionGroup");
		$I->comment("Add product 1 to cart");
		$I->comment("Entering Action Group [addToCartFromStorefrontProductPage] AddToCartFromStorefrontProductPageActionGroup");
		$I->click("#product-addtocart-button"); // stepKey: addToCartAddToCartFromStorefrontProductPage
		$I->waitForPageLoad(60); // stepKey: addToCartAddToCartFromStorefrontProductPageWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForAddToCartAddToCartFromStorefrontProductPage
		$I->waitForElementNotVisible("//button/span[text()='Adding...']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddingAddToCartFromStorefrontProductPage
		$I->waitForElementNotVisible("//button/span[text()='Added']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddedAddToCartFromStorefrontProductPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAddToCartFromStorefrontProductPage
		$I->waitForElementVisible("div.message-success.success.message", 30); // stepKey: waitForSuccessMessageAddToCartFromStorefrontProductPage
		$I->see("You added " . $I->retrieveEntityField('createProduct', 'name', 'test') . " to your shopping cart.", "div.message-success.success.message"); // stepKey: seeAddToCartSuccessMessageAddToCartFromStorefrontProductPage
		$I->comment("Exiting Action Group [addToCartFromStorefrontProductPage] AddToCartFromStorefrontProductPageActionGroup");
		$I->comment("Assert sub total on mini shopping cart");
		$I->comment("Entering Action Group [assertSubTotalOnStorefrontMiniCart] AssertSubTotalOnStorefrontMiniCartActionGroup");
		$I->waitForElementVisible("a.showcart", 30); // stepKey: waitForShowCartButtonVisibleAssertSubTotalOnStorefrontMiniCart
		$I->waitForPageLoad(60); // stepKey: waitForShowCartButtonVisibleAssertSubTotalOnStorefrontMiniCartWaitForPageLoad
		$I->click("a.showcart"); // stepKey: clickOnMiniCartAssertSubTotalOnStorefrontMiniCart
		$I->waitForPageLoad(60); // stepKey: clickOnMiniCartAssertSubTotalOnStorefrontMiniCartWaitForPageLoad
		$grabTextFromMiniCartSubtotalFieldAssertSubTotalOnStorefrontMiniCart = $I->grabTextFrom(".block-minicart .amount span.price"); // stepKey: grabTextFromMiniCartSubtotalFieldAssertSubTotalOnStorefrontMiniCart
		$I->assertEquals("$144.47", $grabTextFromMiniCartSubtotalFieldAssertSubTotalOnStorefrontMiniCart, "Mini shopping cart should contain subtotal $144.47"); // stepKey: assertSubtotalFieldFromMiniShoppingCart1AssertSubTotalOnStorefrontMiniCart
		$I->comment("Exiting Action Group [assertSubTotalOnStorefrontMiniCart] AssertSubTotalOnStorefrontMiniCartActionGroup");
	}
}
