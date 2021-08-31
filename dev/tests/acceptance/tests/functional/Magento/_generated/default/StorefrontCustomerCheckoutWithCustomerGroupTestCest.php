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
 * @Title("MC-37259: Place order by Customer with Customer Group assigned")
 * @Description("Customer Group should be assigned to Order when setting Auto Group Assign is enabled for Customer<h3>Test files</h3>app/code/Magento/Checkout/Test/Mftf/Test/StorefrontCustomerCheckoutTest/StorefrontCustomerCheckoutWithCustomerGroupTest.xml<br>")
 * @TestCaseId("MC-37259")
 * @group checkout
 * @group customer
 */
class StorefrontCustomerCheckoutWithCustomerGroupTestCest
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
		$enableAutoGroupAssign = $I->magentoCLI("config:set customer/create_account/auto_group_assign 1", 60); // stepKey: enableAutoGroupAssign
		$I->comment($enableAutoGroupAssign);
		$I->createEntity("createCategory", "hook", "SimpleSubCategory", [], []); // stepKey: createCategory
		$I->createEntity("createSimpleProduct", "hook", "SimpleProduct", ["createCategory"], []); // stepKey: createSimpleProduct
		$I->createEntity("createCustomer", "hook", "Simple_US_Customer", [], []); // stepKey: createCustomer
		$I->comment("Entering Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsAdmin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginAsAdmin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginAsAdmin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsAdmin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsAdminWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsAdmin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsAdmin
		$I->comment("Exiting Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->comment("Entering Action Group [updateCustomerGroup] AdminUpdateCustomerGroupByEmailActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/customer/index/"); // stepKey: goToCustomerPage01UpdateCustomerGroup
		$I->comment("Start of Action Group: searchAdminDataGridByKeyword");
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clickClearFilters0UpdateCustomerGroup
		$I->waitForPageLoad(30); // stepKey: clickClearFilters0UpdateCustomerGroupWaitForPageLoad
		$I->fillField(".admin__data-grid-header[data-bind='afterRender: \$data.setToolbarNode'] input[placeholder='Search by keyword']", $I->retrieveEntityField('createCustomer', 'email', 'hook')); // stepKey: fillKeywordSearchField01UpdateCustomerGroup
		$I->click(".data-grid-search-control-wrap > button.action-submit"); // stepKey: clickKeywordSearch01UpdateCustomerGroup
		$I->waitForPageLoad(30); // stepKey: clickKeywordSearch01UpdateCustomerGroupWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad02UpdateCustomerGroup
		$I->comment("End of Action Group: searchAdminDataGridByKeyword");
		$I->click("//a[ancestor::tr[contains(., '" . $I->retrieveEntityField('createCustomer', 'email', 'hook') . "')]]"); // stepKey: clickOnCustomer01UpdateCustomerGroup
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad03UpdateCustomerGroup
		$I->conditionalClick("#tab_customer", "#tab_customer", true); // stepKey: clickOnAccountInformation01UpdateCustomerGroup
		$I->waitForPageLoad(30); // stepKey: clickOnAccountInformation01UpdateCustomerGroupWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad04UpdateCustomerGroup
		$I->click("[name='customer[group_id]']"); // stepKey: clickOnCustomerGroup01UpdateCustomerGroup
		$I->selectOption("[name='customer[group_id]']", "Retail"); // stepKey: selectCustomerGroup01UpdateCustomerGroup
		$I->click("#save"); // stepKey: clickOnSave01UpdateCustomerGroup
		$I->waitForPageLoad(30); // stepKey: clickOnSave01UpdateCustomerGroupWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad05UpdateCustomerGroup
		$I->comment("Exiting Action Group [updateCustomerGroup] AdminUpdateCustomerGroupByEmailActionGroup");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$disableAutoGroupAssign = $I->magentoCLI("config:set customer/create_account/auto_group_assign 0", 60); // stepKey: disableAutoGroupAssign
		$I->comment($disableAutoGroupAssign);
		$I->comment("Entering Action Group [logoutCustomer] StorefrontCustomerLogoutActionGroup");
		$I->amOnPage("customer/account/logout/"); // stepKey: storefrontSignOutLogoutCustomer
		$I->waitForPageLoad(30); // stepKey: waitForSignOutLogoutCustomer
		$I->comment("Exiting Action Group [logoutCustomer] StorefrontCustomerLogoutActionGroup");
		$I->deleteEntity("createCustomer", "hook"); // stepKey: deleteUsCustomer
		$I->comment("Entering Action Group [resetCustomerFilters] AdminClearCustomersFiltersActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/customer/index/"); // stepKey: amOnCustomersPageResetCustomerFilters
		$I->waitForPageLoad(30); // stepKey: WaitForPageToLoadResetCustomerFilters
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clickOnButtonToRemoveFiltersIfPresentResetCustomerFilters
		$I->waitForPageLoad(30); // stepKey: clickOnButtonToRemoveFiltersIfPresentResetCustomerFiltersWaitForPageLoad
		$I->comment("Exiting Action Group [resetCustomerFilters] AdminClearCustomersFiltersActionGroup");
		$I->comment("Entering Action Group [logoutFromAdmin] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageLogoutFromAdmin
		$I->comment("Exiting Action Group [logoutFromAdmin] AdminLogoutActionGroup");
		$I->deleteEntity("createSimpleProduct", "hook"); // stepKey: deleteSimpleProduct
		$I->deleteEntity("createCategory", "hook"); // stepKey: deleteSimpleCategory
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
	 * @Features({"Checkout"})
	 * @Stories({"Customer checkout with Customer Group assigned"})
	 * @Severity(level = SeverityLevel::NORMAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function StorefrontCustomerCheckoutWithCustomerGroupTest(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [storefrontCustomerLogin] LoginToStorefrontActionGroup");
		$I->amOnPage("/customer/account/login/"); // stepKey: amOnSignInPageStorefrontCustomerLogin
		$I->waitForPageLoad(30); // stepKey: waitPageFullyLoadedStorefrontCustomerLogin
		$I->waitForElementVisible("#email", 30); // stepKey: waitFormAppearsStorefrontCustomerLogin
		$I->fillField("#email", $I->retrieveEntityField('createCustomer', 'email', 'test')); // stepKey: fillEmailStorefrontCustomerLogin
		$I->fillField("#pass", $I->retrieveEntityField('createCustomer', 'password', 'test')); // stepKey: fillPasswordStorefrontCustomerLogin
		$I->click("#send2"); // stepKey: clickSignInAccountButtonStorefrontCustomerLogin
		$I->waitForPageLoad(30); // stepKey: clickSignInAccountButtonStorefrontCustomerLoginWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCustomerLoggedInStorefrontCustomerLogin
		$I->comment("Exiting Action Group [storefrontCustomerLogin] LoginToStorefrontActionGroup");
		$I->comment("Entering Action Group [navigateToCategoryPage] StorefrontNavigateCategoryPageActionGroup");
		$I->comment("Open category page on storefront");
		$I->amOnPage("/" . $I->retrieveEntityField('createCategory', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: navigateStorefrontCategoryPageNavigateToCategoryPage
		$I->waitForPageLoad(30); // stepKey: waitForCategoryPageLoadNavigateToCategoryPage
		$I->comment("Exiting Action Group [navigateToCategoryPage] StorefrontNavigateCategoryPageActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForCatalogPageLoad
		$I->comment("Entering Action Group [addProductToCart] StorefrontAddCategoryProductToCartActionGroup");
		$I->moveMouseOver("//main//li[.//a[contains(text(), '" . $I->retrieveEntityField('createSimpleProduct', 'name', 'test') . "')]]//div[@class='product-item-info']"); // stepKey: moveMouseOverProductAddProductToCart
		$I->click("//main//li[.//a[contains(text(), '" . $I->retrieveEntityField('createSimpleProduct', 'name', 'test') . "')]]//button[contains(@class, 'tocart')]"); // stepKey: clickAddToCartAddProductToCart
		$I->waitForElementVisible("div.message-success", 30); // stepKey: waitForSuccessMessageAddProductToCart
		$I->see("You added " . $I->retrieveEntityField('createSimpleProduct', 'name', 'test') . " to your shopping cart.", "div.message-success"); // stepKey: assertSuccessMessageAddProductToCart
		$I->seeLink("shopping cart", getenv("MAGENTO_BASE_URL") . "checkout/cart/"); // stepKey: assertLinkToShoppingCartAddProductToCart
		$I->waitForText("1", 30, "//header//div[contains(@class, 'minicart-wrapper')]//a[contains(@class, 'showcart')]//span[@class='counter-number']"); // stepKey: assertProductCountAddProductToCart
		$I->comment("Exiting Action Group [addProductToCart] StorefrontAddCategoryProductToCartActionGroup");
		$I->comment("Entering Action Group [goToCheckoutFromMinicart] GoToCheckoutFromMinicartActionGroup");
		$I->waitForElementNotVisible(".counter.qty.empty", 30); // stepKey: waitUpdateQuantityGoToCheckoutFromMinicart
		$I->wait(5); // stepKey: waitMinicartRenderingGoToCheckoutFromMinicart
		$I->click("a.showcart"); // stepKey: clickCartGoToCheckoutFromMinicart
		$I->waitForPageLoad(60); // stepKey: clickCartGoToCheckoutFromMinicartWaitForPageLoad
		$I->click("#top-cart-btn-checkout"); // stepKey: goToCheckoutGoToCheckoutFromMinicart
		$I->waitForPageLoad(30); // stepKey: goToCheckoutGoToCheckoutFromMinicartWaitForPageLoad
		$I->comment("Exiting Action Group [goToCheckoutFromMinicart] GoToCheckoutFromMinicartActionGroup");
		$I->comment("Entering Action Group [selectFlatRate] CheckoutSelectFlatRateShippingMethodActionGroup");
		$I->conditionalClick("//div[@id='checkout-shipping-method-load']//td[contains(., 'Flat Rate')]/..//input", "//div[@id='checkout-shipping-method-load']//td[contains(., 'Flat Rate')]/..//input", true); // stepKey: selectFlatRateShippingMethodSelectFlatRate
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskForNextButtonSelectFlatRate
		$I->comment("Exiting Action Group [selectFlatRate] CheckoutSelectFlatRateShippingMethodActionGroup");
		$I->comment("Entering Action Group [goToReview] StorefrontCheckoutForwardFromShippingStepActionGroup");
		$I->waitForElementVisible("button.button.action.continue.primary", 30); // stepKey: waitForNextButtonGoToReview
		$I->waitForPageLoad(30); // stepKey: waitForNextButtonGoToReviewWaitForPageLoad
		$I->click("button.button.action.continue.primary"); // stepKey: clickNextGoToReview
		$I->waitForPageLoad(30); // stepKey: clickNextGoToReviewWaitForPageLoad
		$I->comment("Exiting Action Group [goToReview] StorefrontCheckoutForwardFromShippingStepActionGroup");
		$I->comment("Entering Action Group [selectCheckMoneyOrder] CheckoutSelectCheckMoneyOrderPaymentActionGroup");
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskSelectCheckMoneyOrder
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadSelectCheckMoneyOrder
		$I->conditionalClick("//div[@id='checkout-payment-method-load']//div[@class='payment-method']//label//span[contains(., 'Check / Money order')]/../..//input", "//div[@id='checkout-payment-method-load']//div[@class='payment-method']//label//span[contains(., 'Check / Money order')]/../..//input", true); // stepKey: selectCheckmoPaymentMethodSelectCheckMoneyOrder
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskAfterPaymentMethodSelectionSelectCheckMoneyOrder
		$I->comment("Exiting Action Group [selectCheckMoneyOrder] CheckoutSelectCheckMoneyOrderPaymentActionGroup");
		$I->comment("Entering Action Group [clickOnPlaceOrder] CheckoutPlaceOrderActionGroup");
		$I->waitForElementVisible(".payment-method._active button.action.primary.checkout", 30); // stepKey: waitForPlaceOrderButtonClickOnPlaceOrder
		$I->waitForPageLoad(30); // stepKey: waitForPlaceOrderButtonClickOnPlaceOrderWaitForPageLoad
		$I->click(".payment-method._active button.action.primary.checkout"); // stepKey: clickPlaceOrderClickOnPlaceOrder
		$I->waitForPageLoad(30); // stepKey: clickPlaceOrderClickOnPlaceOrderWaitForPageLoad
		$I->see("Your order number is:", "div.checkout-success"); // stepKey: seeOrderNumberClickOnPlaceOrder
		$I->see("We'll email you an order confirmation with details and tracking info.", "div.checkout-success"); // stepKey: seeEmailYouClickOnPlaceOrder
		$I->comment("Exiting Action Group [clickOnPlaceOrder] CheckoutPlaceOrderActionGroup");
		$orderNumber = $I->grabTextFrom(".order-number>strong"); // stepKey: orderNumber
		$I->comment("Entering Action Group [addFilterToGridAndOpenOrder] OpenOrderByIdActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/sales/order/"); // stepKey: navigateToOrderGridPageAddFilterToGridAndOpenOrder
		$I->waitForPageLoad(30); // stepKey: waitForOrdersPageAddFilterToGridAndOpenOrder
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clearExistingOrderFiltersAddFilterToGridAndOpenOrder
		$I->waitForPageLoad(30); // stepKey: clearExistingOrderFiltersAddFilterToGridAndOpenOrderWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForClearFiltersAddFilterToGridAndOpenOrder
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openOrderGridFiltersAddFilterToGridAndOpenOrder
		$I->waitForPageLoad(30); // stepKey: openOrderGridFiltersAddFilterToGridAndOpenOrderWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForClickFiltersAddFilterToGridAndOpenOrder
		$I->fillField(".admin__data-grid-filters input[name='increment_id']", $orderNumber); // stepKey: fillOrderIdFilterAddFilterToGridAndOpenOrder
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickOrderApplyFiltersAddFilterToGridAndOpenOrder
		$I->waitForPageLoad(30); // stepKey: clickOrderApplyFiltersAddFilterToGridAndOpenOrderWaitForPageLoad
		$I->click("table.data-grid tbody > tr:nth-of-type(1)"); // stepKey: openOrderViewPageAddFilterToGridAndOpenOrder
		$I->waitForPageLoad(60); // stepKey: openOrderViewPageAddFilterToGridAndOpenOrderWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForOrderViewPageOpenedAddFilterToGridAndOpenOrder
		$I->waitForPageLoad(30); // stepKey: waitForApplyFiltersAddFilterToGridAndOpenOrder
		$I->comment("Exiting Action Group [addFilterToGridAndOpenOrder] OpenOrderByIdActionGroup");
		$I->see("Pending", ".order-information table.order-information-table #order_status"); // stepKey: verifyOrderStatus
		$I->see("Customer", ".order-account-information-table"); // stepKey: verifyAccountInformation
		$I->see($I->retrieveEntityField('createCustomer', 'email', 'test'), ".order-account-information-table"); // stepKey: verifyCustomerEmail
		$I->see("Retail", ".order-account-information-table"); // stepKey: verifyCustomerGroup
		$I->see("7700 West Parmer Lane", ".order-billing-address"); // stepKey: verifyBillingAddress
		$I->see("7700 West Parmer Lane", ".order-shipping-address"); // stepKey: verifyShippingAddress
		$I->see($I->retrieveEntityField('createSimpleProduct', 'name', 'test'), ".edit-order-table"); // stepKey: verifyProductName
	}
}
