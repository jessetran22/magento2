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
 * @Title("[NO TESTCASEID]: Special prices shown on category when Admin user Login as customer account")
 * @Description("Login as customer sees special prices on category<h3>Test files</h3>app/code/Magento/LoginAsCustomer/Test/Mftf/Test/StorefrontLoginAsCustomerSeeSpecialPriceOnCategoryTest.xml<br>")
 * @group login_as_customer
 */
class StorefrontLoginAsCustomerSeeSpecialPriceOnCategoryTestCest
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
		$enableLoginAsCustomer = $I->magentoCLI("config:set login_as_customer/general/enabled 1", 60); // stepKey: enableLoginAsCustomer
		$I->comment($enableLoginAsCustomer);
		$I->comment("Adding the comment to replace CliCacheFlushActionGroup action group ('cache:flush' command) for preserving Backward Compatibility");
		$I->createEntity("createCategory", "hook", "_defaultCategory", [], []); // stepKey: createCategory
		$createProductFields['price'] = "10";
		$I->createEntity("createProduct", "hook", "SimpleProduct", ["createCategory"], $createProductFields); // stepKey: createProduct
		$createCustomerFields['group_id'] = "3";
		$I->createEntity("createCustomer", "hook", "Simple_US_Customer_Assistance_Allowed", [], $createCustomerFields); // stepKey: createCustomer
		$I->comment("Entering Action Group [login] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLogin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLogin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLogin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLogin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLogin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLogin
		$I->comment("Exiting Action Group [login] AdminLoginActionGroup");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog_rule/promo_catalog/"); // stepKey: goToPriceRulePage
		$I->comment("Entering Action Group [deletePriceRule] deleteEntitySecondaryGrid");
		$I->comment("search for the name");
		$I->click("[title='Reset Filter']"); // stepKey: resetFiltersDeletePriceRule
		$I->fillField(".col-name .admin__control-text", "CatalogPriceRule" . msq("_defaultCatalogRule")); // stepKey: fillIdentifierDeletePriceRule
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
		$I->comment("Entering Action Group [logout] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageLogout
		$I->comment("Exiting Action Group [logout] AdminLogoutActionGroup");
		$I->deleteEntity("createCustomer", "hook"); // stepKey: deleteCustomer
		$I->deleteEntity("createCategory", "hook"); // stepKey: deleteCategory
		$I->deleteEntity("createProduct", "hook"); // stepKey: deleteProduct
		$disableLoginAsCustomer = $I->magentoCLI("config:set login_as_customer/general/enabled 0", 60); // stepKey: disableLoginAsCustomer
		$I->comment($disableLoginAsCustomer);
		$I->comment("Adding the comment to replace CliCacheFlushActionGroup action group ('cache:flush' command) for preserving Backward Compatibility");
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
	 * @Features({"LoginAsCustomer"})
	 * @Stories({"'Login as Customer' should see special prices on a category page"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function StorefrontLoginAsCustomerSeeSpecialPriceOnCategoryTest(AcceptanceTester $I)
	{
		$I->comment("Creating a new catalog price rule with 50 percent discount for Retailer customer group");
		$I->comment("Entering Action Group [newCatalogPriceRuleByUIWithConditionIsCategory] NewCatalogPriceRuleByUIWithConditionIsCategoryActionGroup");
		$I->comment("Go to the admin Catalog rule grid and add a new one");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog_rule/promo_catalog/"); // stepKey: goToPriceRulePageNewCatalogPriceRuleByUIWithConditionIsCategory
		$I->waitForPageLoad(30); // stepKey: waitForPriceRulePageNewCatalogPriceRuleByUIWithConditionIsCategory
		$I->click("#add"); // stepKey: addNewRuleNewCatalogPriceRuleByUIWithConditionIsCategory
		$I->waitForPageLoad(30); // stepKey: addNewRuleNewCatalogPriceRuleByUIWithConditionIsCategoryWaitForPageLoad
		$I->comment("Fill the form according the attributes of the entity");
		$I->fillField("[name='name']", "CatalogPriceRule" . msq("_defaultCatalogRule")); // stepKey: fillNameNewCatalogPriceRuleByUIWithConditionIsCategory
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
		$I->fillField("[name='discount_amount']", "10"); // stepKey: fillDiscountValueNewCatalogPriceRuleByUIWithConditionIsCategory
		$I->selectOption("[name='simple_action']", "by_percent"); // stepKey: discountTypeNewCatalogPriceRuleByUIWithConditionIsCategory
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
		$I->comment("Entering Action Group [selectRetailerCustomerGroup] SelectRetailerCustomerGroupActionGroup");
		$I->comment("This actionGroup was created to be merged from B2B. Retailer Customer Group");
		$I->selectOption("select[name='customer_group_ids']", "Retailer"); // stepKey: selectRetailerCustomerGroupSelectRetailerCustomerGroup
		$I->comment("Exiting Action Group [selectRetailerCustomerGroup] SelectRetailerCustomerGroupActionGroup");
		$I->comment("Entering Action Group [fillActionsForCatalogPriceRule] AdminCatalogPriceRuleFillActionsActionGroup");
		$I->conditionalClick("[data-index='actions'] .fieldset-wrapper-title", "[data-index='actions'] .admin__fieldset-wrapper-content", false); // stepKey: openActionSectionIfNeededFillActionsForCatalogPriceRule
		$I->scrollTo("[data-index='actions'] .fieldset-wrapper-title"); // stepKey: scrollToActionsFieldsetFillActionsForCatalogPriceRule
		$I->waitForElementVisible("[name='simple_action']", 30); // stepKey: waitActionsFieldsetFullyOpenedFillActionsForCatalogPriceRule
		$I->selectOption("[name='simple_action']", "to_percent"); // stepKey: fillDiscountTypeFillActionsForCatalogPriceRule
		$I->fillField("[name='discount_amount']", "50"); // stepKey: fillDiscountAmountFillActionsForCatalogPriceRule
		$I->selectOption("[name='stop_rules_processing']", "Yes"); // stepKey: fillDiscardSubsequentRulesFillActionsForCatalogPriceRule
		$I->comment("Exiting Action Group [fillActionsForCatalogPriceRule] AdminCatalogPriceRuleFillActionsActionGroup");
		$I->comment("Save and apply the new catalog price rule");
		$I->comment("Entering Action Group [saveAndApplyCatalogPriceRule] SaveAndApplyCatalogPriceRuleActionGroup");
		$I->waitForElementVisible("#save_and_apply", 30); // stepKey: waitForSaveAndApplyButtonSaveAndApplyCatalogPriceRule
		$I->waitForPageLoad(30); // stepKey: waitForSaveAndApplyButtonSaveAndApplyCatalogPriceRuleWaitForPageLoad
		$I->click("#save_and_apply"); // stepKey: saveAndApplySaveAndApplyCatalogPriceRule
		$I->waitForPageLoad(30); // stepKey: saveAndApplySaveAndApplyCatalogPriceRuleWaitForPageLoad
		$I->see("You saved the rule.", ".message-success"); // stepKey: assertSuccessSaveAndApplyCatalogPriceRule
		$I->comment("Exiting Action Group [saveAndApplyCatalogPriceRule] SaveAndApplyCatalogPriceRuleActionGroup");
		$I->comment("Adding the comment to replace CliIndexerReindexActionGroup action group ('indexer:reindex' commands) for preserving Backward Compatibility");
		$I->comment("Adding the comment to replace CliCacheFlushActionGroup action group ('cache:flush' command) for preserving Backward Compatibility");
		$I->comment("Admin Login as Customer");
		$I->comment("Entering Action Group [loginAsCustomerFromCustomerPage] AdminLoginAsCustomerLoginFromCustomerPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/customer/index/edit/id/" . $I->retrieveEntityField('createCustomer', 'id', 'test')); // stepKey: gotoCustomerPageLoginAsCustomerFromCustomerPage
		$I->waitForPageLoad(30); // stepKey: waitForCustomerPageLoadLoginAsCustomerFromCustomerPage
		$I->click("#login_as_customer"); // stepKey: clickLoginAsCustomerLinkLoginAsCustomerFromCustomerPage
		$I->waitForPageLoad(30); // stepKey: clickLoginAsCustomerLinkLoginAsCustomerFromCustomerPageWaitForPageLoad
		$I->see("You are about to Login as Customer", "aside.confirm .modal-title"); // stepKey: seeModalLoginAsCustomerFromCustomerPage
		$I->see("Actions taken while in \"Login as Customer\" will affect actual customer data.", "aside.confirm .modal-content"); // stepKey: seeModalMessageLoginAsCustomerFromCustomerPage
		$I->click("aside.confirm .modal-footer button.action-accept"); // stepKey: clickLoginLoginAsCustomerFromCustomerPage
		$I->waitForPageLoad(60); // stepKey: clickLoginLoginAsCustomerFromCustomerPageWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForLoadingMaskToDisappearLoginAsCustomerFromCustomerPage
		$I->switchToNextTab(); // stepKey: switchToNewTabLoginAsCustomerFromCustomerPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadLoginAsCustomerFromCustomerPage
		$I->comment("Exiting Action Group [loginAsCustomerFromCustomerPage] AdminLoginAsCustomerLoginFromCustomerPageActionGroup");
		$I->comment("Entering Action Group [assertNotificationBanner] StorefrontAssertLoginAsCustomerNotificationBannerActionGroup");
		$I->waitForElementVisible("//div[contains(@class, 'lac-notification')]//div[contains(@class, 'lac-notification-text')]/span", 30); // stepKey: waitForNotificationBannerAssertNotificationBanner
		$I->waitForPageLoad(30); // stepKey: waitForNotificationBannerAssertNotificationBannerWaitForPageLoad
		$I->see("You are connected as " . $I->retrieveEntityField('createCustomer', 'firstname', 'test') . " " . $I->retrieveEntityField('createCustomer', 'lastname', 'test') . " on Main Website", "//div[contains(@class, 'lac-notification')]//div[contains(@class, 'lac-notification-text')]/span"); // stepKey: assertCorrectNotificationBannerMessageAssertNotificationBanner
		$I->waitForPageLoad(30); // stepKey: assertCorrectNotificationBannerMessageAssertNotificationBannerWaitForPageLoad
		$I->seeElement("//div[contains(@class, 'lac-notification')]//div[contains(@class, 'lac-notification-links')]/a[contains(@class, 'lac-notification-close-link')]"); // stepKey: assertCloseNotificationBannerPresentAssertNotificationBanner
		$I->waitForPageLoad(30); // stepKey: assertCloseNotificationBannerPresentAssertNotificationBannerWaitForPageLoad
		$I->comment("Exiting Action Group [assertNotificationBanner] StorefrontAssertLoginAsCustomerNotificationBannerActionGroup");
		$I->comment("Check simple product prices on store front category page");
		$I->amOnPage("/" . $I->retrieveEntityField('createCategory', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: navigateToCategoryPage
		$I->comment("Entering Action Group [storefrontProduct1Price] AssertProductDetailsOnStorefrontActionGroup");
		$I->see("$5.00", "//main//li[1]//div[@class='product-item-info']"); // stepKey: seeProductInfoStorefrontProduct1Price
		$I->comment("Exiting Action Group [storefrontProduct1Price] AssertProductDetailsOnStorefrontActionGroup");
		$I->comment("Entering Action Group [storefrontProduct1RegularPrice] AssertProductDetailsOnStorefrontActionGroup");
		$I->see("$10.00", "//main//li[1]//div[@class='product-item-info']"); // stepKey: seeProductInfoStorefrontProduct1RegularPrice
		$I->comment("Exiting Action Group [storefrontProduct1RegularPrice] AssertProductDetailsOnStorefrontActionGroup");
		$I->comment("Place order");
		$I->comment("Entering Action Group [openProductPage] StorefrontOpenProductPageActionGroup");
		$I->amOnPage("/" . $I->retrieveEntityField('createProduct', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: openProductPageOpenProductPage
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoadedOpenProductPage
		$I->comment("Exiting Action Group [openProductPage] StorefrontOpenProductPageActionGroup");
		$I->comment("Entering Action Group [addProductToCart] StorefrontAddProductToCartActionGroup");
		$I->click("button#product-addtocart-button"); // stepKey: clickAddToCartAddProductToCart
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAddProductToCart
		$I->waitForElementVisible("div.message-success", 30); // stepKey: waitForSuccessMessageAddProductToCart
		$I->see("You added " . $I->retrieveEntityField('createProduct', 'name', 'test') . " to your shopping cart.", ".page.messages"); // stepKey: assertSuccessMessageAddProductToCart
		$I->waitForPageLoad(30); // stepKey: assertSuccessMessageAddProductToCartWaitForPageLoad
		$I->seeLink("shopping cart", getenv("MAGENTO_BASE_URL") . "checkout/cart/"); // stepKey: assertLinkToShoppingCartAddProductToCart
		$I->waitForText("1", 30, "//header//div[contains(@class, 'minicart-wrapper')]//a[contains(@class, 'showcart')]//span[@class='counter-number']"); // stepKey: assertProductCountAddProductToCart
		$I->comment("Exiting Action Group [addProductToCart] StorefrontAddProductToCartActionGroup");
		$I->comment("Entering Action Group [openCart] StorefrontCartPageOpenActionGroup");
		$I->amOnPage("/checkout/cart"); // stepKey: openCartPageOpenCart
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadedOpenCart
		$I->comment("Exiting Action Group [openCart] StorefrontCartPageOpenActionGroup");
		$I->comment("Entering Action Group [placeOrder] PlaceOrderWithLoggedUserActionGroup");
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForCartTotalsLoadedPlaceOrder
		$I->waitForElementVisible(".grand.totals .amount .price", 30); // stepKey: waitForCartGrandTotalVisiblePlaceOrder
		$I->waitForElementVisible(".action.primary.checkout span", 30); // stepKey: waitProceedToCheckoutPlaceOrder
		$I->waitForPageLoad(30); // stepKey: waitProceedToCheckoutPlaceOrderWaitForPageLoad
		$I->click(".action.primary.checkout span"); // stepKey: clickProceedToCheckoutPlaceOrder
		$I->waitForPageLoad(30); // stepKey: clickProceedToCheckoutPlaceOrderWaitForPageLoad
		$I->click("//div[@id='checkout-shipping-method-load']//td[contains(., '')]/..//input"); // stepKey: selectShippingMethodPlaceOrder
		$I->waitForElement("button.button.action.continue.primary", 30); // stepKey: waitForNextButtonPlaceOrder
		$I->waitForPageLoad(30); // stepKey: waitForNextButtonPlaceOrderWaitForPageLoad
		$I->click("button.button.action.continue.primary"); // stepKey: clickNextPlaceOrder
		$I->waitForPageLoad(30); // stepKey: clickNextPlaceOrderWaitForPageLoad
		$I->waitForElement("//*[@id='checkout-payment-method-load']//div[@data-role='title']", 30); // stepKey: waitForPaymentSectionLoadedPlaceOrder
		$I->seeInCurrentUrl("/checkout/#payment"); // stepKey: assertCheckoutPaymentUrlPlaceOrder
		$I->waitForElementVisible(".payment-method._active button.action.primary.checkout", 30); // stepKey: waitForPlaceOrderButtonPlaceOrder
		$I->waitForPageLoad(30); // stepKey: waitForPlaceOrderButtonPlaceOrderWaitForPageLoad
		$I->click(".payment-method._active button.action.primary.checkout"); // stepKey: clickPlaceOrderPlaceOrder
		$I->waitForPageLoad(30); // stepKey: clickPlaceOrderPlaceOrderWaitForPageLoad
		$I->see("Thank you for your purchase!", ".page-title"); // stepKey: waitForLoadSuccessPagePlaceOrder
		$I->comment("Exiting Action Group [placeOrder] PlaceOrderWithLoggedUserActionGroup");
		$grabOrderId = $I->grabTextFrom(".order-number>strong"); // stepKey: grabOrderId
		$I->closeTab(); // stepKey: closeLoginAsCustomerTab
		$I->comment("Open order in admin");
		$I->comment("Entering Action Group [addFilterToGridAndOpenOrder] OpenOrderByIdActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/sales/order/"); // stepKey: navigateToOrderGridPageAddFilterToGridAndOpenOrder
		$I->waitForPageLoad(30); // stepKey: waitForOrdersPageAddFilterToGridAndOpenOrder
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clearExistingOrderFiltersAddFilterToGridAndOpenOrder
		$I->waitForPageLoad(30); // stepKey: clearExistingOrderFiltersAddFilterToGridAndOpenOrderWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForClearFiltersAddFilterToGridAndOpenOrder
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openOrderGridFiltersAddFilterToGridAndOpenOrder
		$I->waitForPageLoad(30); // stepKey: openOrderGridFiltersAddFilterToGridAndOpenOrderWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForClickFiltersAddFilterToGridAndOpenOrder
		$I->fillField(".admin__data-grid-filters input[name='increment_id']", $grabOrderId); // stepKey: fillOrderIdFilterAddFilterToGridAndOpenOrder
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickOrderApplyFiltersAddFilterToGridAndOpenOrder
		$I->waitForPageLoad(30); // stepKey: clickOrderApplyFiltersAddFilterToGridAndOpenOrderWaitForPageLoad
		$I->click("table.data-grid tbody > tr:nth-of-type(1)"); // stepKey: openOrderViewPageAddFilterToGridAndOpenOrder
		$I->waitForPageLoad(60); // stepKey: openOrderViewPageAddFilterToGridAndOpenOrderWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForOrderViewPageOpenedAddFilterToGridAndOpenOrder
		$I->waitForPageLoad(30); // stepKey: waitForApplyFiltersAddFilterToGridAndOpenOrder
		$I->comment("Exiting Action Group [addFilterToGridAndOpenOrder] OpenOrderByIdActionGroup");
		$I->comment("Assert order subtotal");
		$I->scrollTo(".order-subtotal-table tbody tr.col-0>td span.price"); // stepKey: scrollToOrderTotalSection
		$I->see("$5.00", ".order-subtotal-table tbody tr.col-0>td span.price"); // stepKey: checkOrderTotalInBackend
	}
}
