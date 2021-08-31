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
 * @Title("MC-14772: Admin should be able to apply the catalog price rule for simple product for new customer group")
 * @Description("Admin should be able to apply the catalog price rule for simple product for new customer group<h3>Test files</h3>app/code/Magento/CatalogRule/Test/Mftf/Test/ApplyCatalogRuleForSimpleProductForNewCustomerGroupTest.xml<br>")
 * @TestCaseId("MC-14772")
 * @group CatalogRule
 * @group mtf_migrated
 */
class ApplyCatalogRuleForSimpleProductForNewCustomerGroupTestCest
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
		$I->comment("Create new customer group");
		$I->createEntity("customerGroup", "hook", "CustomCustomerGroup", [], []); // stepKey: customerGroup
		$createCustomerFields['group_id'] = $I->retrieveEntityField('customerGroup', 'id', 'hook');
		$I->createEntity("createCustomer", "hook", "Simple_US_Customer", [], $createCustomerFields); // stepKey: createCustomer
		$I->createEntity("createCategory", "hook", "_defaultCategory", [], []); // stepKey: createCategory
		$createSimpleProductFields['price'] = "56.78";
		$I->createEntity("createSimpleProduct", "hook", "_defaultProduct", ["createCategory"], $createSimpleProductFields); // stepKey: createSimpleProduct
		$runCronIndex = $I->magentoCron("index", 90); // stepKey: runCronIndex
		$I->comment($runCronIndex);
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Delete products and category");
		$I->deleteEntity("createSimpleProduct", "hook"); // stepKey: deleteSimpleProduct
		$I->deleteEntity("createCategory", "hook"); // stepKey: deleteCategory
		$I->comment("Customer Log Out");
		$I->comment("Entering Action Group [customerLogout] StorefrontCustomerLogoutActionGroup");
		$I->amOnPage("customer/account/logout/"); // stepKey: storefrontSignOutCustomerLogout
		$I->waitForPageLoad(30); // stepKey: waitForSignOutCustomerLogout
		$I->comment("Exiting Action Group [customerLogout] StorefrontCustomerLogoutActionGroup");
		$I->comment("Delete customer");
		$I->deleteEntity("createCustomer", "hook"); // stepKey: deleteCustomer
		$I->comment("Delete customer group");
		$I->deleteEntity("customerGroup", "hook"); // stepKey: deleteCustomerGroup
		$I->comment("Delete the catalog price rule");
		$I->comment("Entering Action Group [goToPriceRulePage] AdminOpenCatalogPriceRulePageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog_rule/promo_catalog/"); // stepKey: openCatalogRulePageGoToPriceRulePage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadGoToPriceRulePage
		$I->comment("Exiting Action Group [goToPriceRulePage] AdminOpenCatalogPriceRulePageActionGroup");
		$I->comment("Entering Action Group [deletePriceRule] deleteEntitySecondaryGrid");
		$I->comment("search for the name");
		$I->click("[title='Reset Filter']"); // stepKey: resetFiltersDeletePriceRule
		$I->fillField(".col-name .admin__control-text", "CatalogPriceRule" . msq("CatalogRuleByFixed")); // stepKey: fillIdentifierDeletePriceRule
		$I->click(".admin__filter-actions [title='Search']"); // stepKey: searchForNameDeletePriceRule
		$I->click("tr[data-role='row']"); // stepKey: clickResultDeletePriceRule
		$I->waitForPageLoad(30); // stepKey: waitForTaxRateLoadDeletePriceRule
		$I->comment("delete the rule");
		$I->click("#delete"); // stepKey: clickDeleteDeletePriceRule
		$I->waitForPageLoad(30); // stepKey: clickDeleteDeletePriceRuleWaitForPageLoad
		$I->click("aside.confirm .modal-footer button.action-accept"); // stepKey: clickOkDeletePriceRule
		$I->waitForPageLoad(60); // stepKey: clickOkDeletePriceRuleWaitForPageLoad
		$I->see("deleted", ".message-success"); // stepKey: seeSuccessDeletePriceRule
		$I->comment("Exiting Action Group [deletePriceRule] deleteEntitySecondaryGrid");
		$I->comment("Logout");
		$I->comment("Entering Action Group [logout] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageLogout
		$I->comment("Exiting Action Group [logout] AdminLogoutActionGroup");
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
	public function ApplyCatalogRuleForSimpleProductForNewCustomerGroupTest(AcceptanceTester $I)
	{
		$I->comment("1. Begin creating a new catalog price rule");
		$I->comment("Entering Action Group [newCatalogPriceRuleByUIWithConditionIsCategory] NewCatalogPriceRuleByUIWithConditionIsCategoryActionGroup");
		$I->comment("Go to the admin Catalog rule grid and add a new one");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog_rule/promo_catalog/"); // stepKey: goToPriceRulePageNewCatalogPriceRuleByUIWithConditionIsCategory
		$I->waitForPageLoad(30); // stepKey: waitForPriceRulePageNewCatalogPriceRuleByUIWithConditionIsCategory
		$I->click("#add"); // stepKey: addNewRuleNewCatalogPriceRuleByUIWithConditionIsCategory
		$I->waitForPageLoad(30); // stepKey: addNewRuleNewCatalogPriceRuleByUIWithConditionIsCategoryWaitForPageLoad
		$I->comment("Fill the form according the attributes of the entity");
		$I->fillField("[name='name']", "CatalogPriceRule" . msq("CatalogRuleByFixed")); // stepKey: fillNameNewCatalogPriceRuleByUIWithConditionIsCategory
		$I->fillField("[name='description']", "Catalog Price Rule Description"); // stepKey: fillDescriptionNewCatalogPriceRuleByUIWithConditionIsCategory
		$I->click("input[name='is_active']+label"); // stepKey: selectActiveNewCatalogPriceRuleByUIWithConditionIsCategory
		$I->selectOption("[name='website_ids']", "1"); // stepKey: selectSiteNewCatalogPriceRuleByUIWithConditionIsCategory
		$I->click("[name='from_date'] + button"); // stepKey: clickFromCalenderNewCatalogPriceRuleByUIWithConditionIsCategory
		$I->waitForPageLoad(15); // stepKey: clickFromCalenderNewCatalogPriceRuleByUIWithConditionIsCategoryWaitForPageLoad
		$I->click("#ui-datepicker-div [data-handler='today']"); // stepKey: clickFromTodayNewCatalogPriceRuleByUIWithConditionIsCategory
		$I->click("[name='to_date'] + button"); // stepKey: clickToCalenderNewCatalogPriceRuleByUIWithConditionIsCategory
		$I->waitForPageLoad(15); // stepKey: clickToCalenderNewCatalogPriceRuleByUIWithConditionIsCategoryWaitForPageLoad
		$I->click("#ui-datepicker-div [data-handler='today']"); // stepKey: clickToTodayNewCatalogPriceRuleByUIWithConditionIsCategory
		$I->click("[data-index='actions']"); // stepKey: openActionDropdownNewCatalogPriceRuleByUIWithConditionIsCategory
		$I->fillField("[name='discount_amount']", "12.3"); // stepKey: fillDiscountValueNewCatalogPriceRuleByUIWithConditionIsCategory
		$I->selectOption("[name='simple_action']", "by_fixed"); // stepKey: discountTypeNewCatalogPriceRuleByUIWithConditionIsCategory
		$I->selectOption("[name='stop_rules_processing']", "Yes"); // stepKey: discardSubsequentRulesNewCatalogPriceRuleByUIWithConditionIsCategory
		$I->click("[data-index='block_promo_catalog_edit_tab_conditions']"); // stepKey: openConditionsTabNewCatalogPriceRuleByUIWithConditionIsCategory
		$I->waitForPageLoad(30); // stepKey: waitForConditionTabOpenedNewCatalogPriceRuleByUIWithConditionIsCategory
		$I->click(".rule-param.rule-param-new-child"); // stepKey: addNewConditionNewCatalogPriceRuleByUIWithConditionIsCategory
		$I->waitForPageLoad(30); // stepKey: addNewConditionNewCatalogPriceRuleByUIWithConditionIsCategoryWaitForPageLoad
		$I->selectOption("select#conditions__1__new_child", "Magento\CatalogRule\Model\Rule\Condition\Product|category_ids"); // stepKey: selectTypeConditionNewCatalogPriceRuleByUIWithConditionIsCategory
		$I->waitForPageLoad(30); // stepKey: selectTypeConditionNewCatalogPriceRuleByUIWithConditionIsCategoryWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForConditionChosedNewCatalogPriceRuleByUIWithConditionIsCategory
		$I->click("//li[1]//a[@class='label'][text() = '...']"); // stepKey: clickEllipsisNewCatalogPriceRuleByUIWithConditionIsCategory
		$I->fillField("input#conditions__1--1__value", $I->retrieveEntityField('createCategory', 'id', 'test')); // stepKey: fillCategoryIdNewCatalogPriceRuleByUIWithConditionIsCategory
		$I->click("#conditions__1__children li:nth-of-type(1) a.rule-param-apply"); // stepKey: clickApplyNewCatalogPriceRuleByUIWithConditionIsCategory
		$I->waitForPageLoad(30); // stepKey: clickApplyNewCatalogPriceRuleByUIWithConditionIsCategoryWaitForPageLoad
		$I->comment("Scroll to top and either save or save and apply after the action group");
		$I->scrollToTopOfPage(); // stepKey: scrollToTopNewCatalogPriceRuleByUIWithConditionIsCategory
		$I->waitForPageLoad(30); // stepKey: waitForAppliedNewCatalogPriceRuleByUIWithConditionIsCategory
		$I->comment("Exiting Action Group [newCatalogPriceRuleByUIWithConditionIsCategory] NewCatalogPriceRuleByUIWithConditionIsCategoryActionGroup");
		$I->comment("Select custom customer group");
		$I->comment("Entering Action Group [selectCustomCustomerGroup] CatalogSelectCustomerGroupActionGroup");
		$I->selectOption("[name='customer_group_ids']", $I->retrieveEntityField('customerGroup', 'code', 'test')); // stepKey: selectCustomerGroupSelectCustomCustomerGroup
		$I->comment("Exiting Action Group [selectCustomCustomerGroup] CatalogSelectCustomerGroupActionGroup");
		$I->comment("Save and apply the new catalog price rule");
		$I->comment("Entering Action Group [saveAndApplyCatalogPriceRule] SaveAndApplyCatalogPriceRuleActionGroup");
		$I->waitForElementVisible("#save_and_apply", 30); // stepKey: waitForSaveAndApplyButtonSaveAndApplyCatalogPriceRule
		$I->waitForPageLoad(30); // stepKey: waitForSaveAndApplyButtonSaveAndApplyCatalogPriceRuleWaitForPageLoad
		$I->click("#save_and_apply"); // stepKey: saveAndApplySaveAndApplyCatalogPriceRule
		$I->waitForPageLoad(30); // stepKey: saveAndApplySaveAndApplyCatalogPriceRuleWaitForPageLoad
		$I->see("You saved the rule.", ".message-success"); // stepKey: assertSuccessSaveAndApplyCatalogPriceRule
		$I->comment("Exiting Action Group [saveAndApplyCatalogPriceRule] SaveAndApplyCatalogPriceRuleActionGroup");
		$I->comment("Adding the comment to replace CliIndexerReindexActionGroup action group ('indexer:reindex' commands) for preserving Backward Compatibility");
		$I->comment("Navigate to category on store front");
		$I->amOnPage("/" . $I->retrieveEntityField('createCategory', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: goToCategoryPage
		$I->comment("Check product 1 name on store front category page");
		$I->comment("Entering Action Group [storefrontProductName] AssertProductDetailsOnStorefrontActionGroup");
		$I->see($I->retrieveEntityField('createSimpleProduct', 'name', 'test'), "//main//li[1]//div[@class='product-item-info']"); // stepKey: seeProductInfoStorefrontProductName
		$I->comment("Exiting Action Group [storefrontProductName] AssertProductDetailsOnStorefrontActionGroup");
		$I->comment("Check product 1 has no discounts applied on store front category page");
		$I->comment("Entering Action Group [storefrontProductRegularPrice] AssertDontSeeProductDetailsOnStorefrontActionGroup");
		$I->dontSee("$44.48", "//main//li[1]//div[@class='product-item-info']"); // stepKey: seeProductInfoStorefrontProductRegularPrice
		$I->comment("Exiting Action Group [storefrontProductRegularPrice] AssertDontSeeProductDetailsOnStorefrontActionGroup");
		$I->comment("Check product 1 price on store front category page");
		$I->comment("Entering Action Group [storefrontProductPrice] AssertProductDetailsOnStorefrontActionGroup");
		$I->see("$56.78", "//main//li[1]//div[@class='product-item-info']"); // stepKey: seeProductInfoStorefrontProductPrice
		$I->comment("Exiting Action Group [storefrontProductPrice] AssertProductDetailsOnStorefrontActionGroup");
		$I->comment("Navigate to product 1 on store front");
		$I->amOnPage("/" . $I->retrieveEntityField('createSimpleProduct', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: goToProductPage
		$I->comment("Add product 1 to cart");
		$I->comment("Entering Action Group [cartAddSimpleProductToCart] StorefrontAddProductToCartWithQtyActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForStorefrontProductPageLoadCartAddSimpleProductToCart
		$I->fillField("input.input-text.qty", "1"); // stepKey: fillProduct1QuantityCartAddSimpleProductToCart
		$I->waitForPageLoad(30); // stepKey: fillProduct1QuantityCartAddSimpleProductToCartWaitForPageLoad
		$I->click("#product-addtocart-button"); // stepKey: clickOnAddToCartButtonCartAddSimpleProductToCart
		$I->waitForPageLoad(60); // stepKey: clickOnAddToCartButtonCartAddSimpleProductToCartWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForProductToAddInCartCartAddSimpleProductToCart
		$I->waitForElementVisible("div.message-success.success.message", 30); // stepKey: waitForSuccessMessageCartAddSimpleProductToCart
		$I->seeElement("div.message-success"); // stepKey: seeSuccessSaveMessageCartAddSimpleProductToCart
		$I->waitForPageLoad(30); // stepKey: seeSuccessSaveMessageCartAddSimpleProductToCartWaitForPageLoad
		$I->comment("Exiting Action Group [cartAddSimpleProductToCart] StorefrontAddProductToCartWithQtyActionGroup");
		$I->comment("Assert sub total on mini shopping cart");
		$I->comment("Entering Action Group [assertSubTotalOnStorefrontMiniCart] AssertSubTotalOnStorefrontMiniCartActionGroup");
		$I->waitForElementVisible("a.showcart", 30); // stepKey: waitForShowCartButtonVisibleAssertSubTotalOnStorefrontMiniCart
		$I->waitForPageLoad(60); // stepKey: waitForShowCartButtonVisibleAssertSubTotalOnStorefrontMiniCartWaitForPageLoad
		$I->click("a.showcart"); // stepKey: clickOnMiniCartAssertSubTotalOnStorefrontMiniCart
		$I->waitForPageLoad(60); // stepKey: clickOnMiniCartAssertSubTotalOnStorefrontMiniCartWaitForPageLoad
		$grabTextFromMiniCartSubtotalFieldAssertSubTotalOnStorefrontMiniCart = $I->grabTextFrom(".block-minicart .amount span.price"); // stepKey: grabTextFromMiniCartSubtotalFieldAssertSubTotalOnStorefrontMiniCart
		$I->assertEquals("$56.78", $grabTextFromMiniCartSubtotalFieldAssertSubTotalOnStorefrontMiniCart, "Mini shopping cart should contain subtotal $56.78"); // stepKey: assertSubtotalFieldFromMiniShoppingCart1AssertSubTotalOnStorefrontMiniCart
		$I->comment("Exiting Action Group [assertSubTotalOnStorefrontMiniCart] AssertSubTotalOnStorefrontMiniCartActionGroup");
		$I->comment("Login to storefront as previously created customer");
		$I->comment("Entering Action Group [loginAsCustomer] LoginToStorefrontActionGroup");
		$I->amOnPage("/customer/account/login/"); // stepKey: amOnSignInPageLoginAsCustomer
		$I->waitForPageLoad(30); // stepKey: waitPageFullyLoadedLoginAsCustomer
		$I->waitForElementVisible("#email", 30); // stepKey: waitFormAppearsLoginAsCustomer
		$I->fillField("#email", $I->retrieveEntityField('createCustomer', 'email', 'test')); // stepKey: fillEmailLoginAsCustomer
		$I->fillField("#pass", $I->retrieveEntityField('createCustomer', 'password', 'test')); // stepKey: fillPasswordLoginAsCustomer
		$I->click("#send2"); // stepKey: clickSignInAccountButtonLoginAsCustomer
		$I->waitForPageLoad(30); // stepKey: clickSignInAccountButtonLoginAsCustomerWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCustomerLoggedInLoginAsCustomer
		$I->comment("Exiting Action Group [loginAsCustomer] LoginToStorefrontActionGroup");
		$I->comment("Navigate to category on store front as customer");
		$I->amOnPage("/" . $I->retrieveEntityField('createCategory', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: goToCategoryPageAsCustomer
		$I->comment("Check simple product name on store front category page");
		$I->comment("Entering Action Group [storefrontProductNameAsCustomer] AssertProductDetailsOnStorefrontActionGroup");
		$I->see($I->retrieveEntityField('createSimpleProduct', 'name', 'test'), "//main//li[1]//div[@class='product-item-info']"); // stepKey: seeProductInfoStorefrontProductNameAsCustomer
		$I->comment("Exiting Action Group [storefrontProductNameAsCustomer] AssertProductDetailsOnStorefrontActionGroup");
		$I->comment("Check simple product price on store front category page as customer");
		$I->comment("Entering Action Group [storefrontProductPriceAsCustomer] AssertProductDetailsOnStorefrontActionGroup");
		$I->see("$44.48", "//main//li[1]//div[@class='product-item-info']"); // stepKey: seeProductInfoStorefrontProductPriceAsCustomer
		$I->comment("Exiting Action Group [storefrontProductPriceAsCustomer] AssertProductDetailsOnStorefrontActionGroup");
		$I->comment("Check simple product regular price on store front category page as customer");
		$I->comment("Entering Action Group [storefrontProductRegularPriceAsCustomer] AssertProductDetailsOnStorefrontActionGroup");
		$I->see("$56.78", "//main//li[1]//div[@class='product-item-info']"); // stepKey: seeProductInfoStorefrontProductRegularPriceAsCustomer
		$I->comment("Exiting Action Group [storefrontProductRegularPriceAsCustomer] AssertProductDetailsOnStorefrontActionGroup");
		$I->comment("Navigate to simple product on store front as customer");
		$I->amOnPage("/" . $I->retrieveEntityField('createSimpleProduct', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: goToProductPage1AsCustomer
		$I->comment("Assert regular and special price as customer");
		$I->comment("Entering Action Group [assertStorefrontProductPrices] AssertStorefrontProductPricesActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForStorefrontProductPageLoadAssertStorefrontProductPrices
		$I->see("$56.78", "div.price-box.price-final_price"); // stepKey: productPriceAmountAssertStorefrontProductPrices
		$I->see("$44.48", "div.price-box.price-final_price [data-price-type='finalPrice'] .price"); // stepKey: productFinalPriceAmountAssertStorefrontProductPrices
		$I->comment("Exiting Action Group [assertStorefrontProductPrices] AssertStorefrontProductPricesActionGroup");
		$I->comment("Add simple product to cart as customer");
		$I->comment("Entering Action Group [cartAddSimpleProductToCartAsCustomer] StorefrontAddProductToCartWithQtyActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForStorefrontProductPageLoadCartAddSimpleProductToCartAsCustomer
		$I->fillField("input.input-text.qty", "1"); // stepKey: fillProduct1QuantityCartAddSimpleProductToCartAsCustomer
		$I->waitForPageLoad(30); // stepKey: fillProduct1QuantityCartAddSimpleProductToCartAsCustomerWaitForPageLoad
		$I->click("#product-addtocart-button"); // stepKey: clickOnAddToCartButtonCartAddSimpleProductToCartAsCustomer
		$I->waitForPageLoad(60); // stepKey: clickOnAddToCartButtonCartAddSimpleProductToCartAsCustomerWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForProductToAddInCartCartAddSimpleProductToCartAsCustomer
		$I->waitForElementVisible("div.message-success.success.message", 30); // stepKey: waitForSuccessMessageCartAddSimpleProductToCartAsCustomer
		$I->seeElement("div.message-success"); // stepKey: seeSuccessSaveMessageCartAddSimpleProductToCartAsCustomer
		$I->waitForPageLoad(30); // stepKey: seeSuccessSaveMessageCartAddSimpleProductToCartAsCustomerWaitForPageLoad
		$I->comment("Exiting Action Group [cartAddSimpleProductToCartAsCustomer] StorefrontAddProductToCartWithQtyActionGroup");
		$I->comment("Assert sub total on mini shopping cart as customer");
		$I->comment("Entering Action Group [assertSubTotalOnStorefrontMiniCartAsCustomer] AssertSubTotalOnStorefrontMiniCartActionGroup");
		$I->waitForElementVisible("a.showcart", 30); // stepKey: waitForShowCartButtonVisibleAssertSubTotalOnStorefrontMiniCartAsCustomer
		$I->waitForPageLoad(60); // stepKey: waitForShowCartButtonVisibleAssertSubTotalOnStorefrontMiniCartAsCustomerWaitForPageLoad
		$I->click("a.showcart"); // stepKey: clickOnMiniCartAssertSubTotalOnStorefrontMiniCartAsCustomer
		$I->waitForPageLoad(60); // stepKey: clickOnMiniCartAssertSubTotalOnStorefrontMiniCartAsCustomerWaitForPageLoad
		$grabTextFromMiniCartSubtotalFieldAssertSubTotalOnStorefrontMiniCartAsCustomer = $I->grabTextFrom(".block-minicart .amount span.price"); // stepKey: grabTextFromMiniCartSubtotalFieldAssertSubTotalOnStorefrontMiniCartAsCustomer
		$I->assertEquals("$88.96", $grabTextFromMiniCartSubtotalFieldAssertSubTotalOnStorefrontMiniCartAsCustomer, "Mini shopping cart should contain subtotal $88.96"); // stepKey: assertSubtotalFieldFromMiniShoppingCart1AssertSubTotalOnStorefrontMiniCartAsCustomer
		$I->comment("Exiting Action Group [assertSubTotalOnStorefrontMiniCartAsCustomer] AssertSubTotalOnStorefrontMiniCartActionGroup");
	}
}
