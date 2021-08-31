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
 * @Title("MC-42694: Verify Customer Order History Comments For Storefront My Account Sales Pages")
 * @Description("Verify that the Customer order History comments without the HTML tags to the My Orders pages on the Storefront<h3>Test files</h3>app/code/Magento/Sales/Test/Mftf/Test/StorefrontVerifyOrderHistoryCommentsTest.xml<br>")
 * @TestCaseId("MC-42694")
 * @group Sales
 */
class StorefrontVerifyOrderHistoryCommentsTestCest
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
		$I->comment("Create customer");
		$I->createEntity("createCustomer", "hook", "Simple_US_Customer", [], []); // stepKey: createCustomer
		$I->comment("Create product");
		$I->createEntity("createProduct", "hook", "SimpleProduct2", [], []); // stepKey: createProduct
		$reindexInvalidatedIndices = $I->magentoCron("index", 90); // stepKey: reindexInvalidatedIndices
		$I->comment($reindexInvalidatedIndices);
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Customer log out");
		$I->comment("Entering Action Group [customerLogout] StorefrontCustomerLogoutActionGroup");
		$I->amOnPage("customer/account/logout/"); // stepKey: storefrontSignOutCustomerLogout
		$I->waitForPageLoad(30); // stepKey: waitForSignOutCustomerLogout
		$I->comment("Exiting Action Group [customerLogout] StorefrontCustomerLogoutActionGroup");
		$I->comment("Admin log out");
		$I->comment("Entering Action Group [logout] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageLogout
		$I->comment("Exiting Action Group [logout] AdminLogoutActionGroup");
		$I->comment("Delete customer");
		$I->deleteEntity("createCustomer", "hook"); // stepKey: deleteCustomer
		$I->comment("Delete product");
		$I->deleteEntity("createProduct", "hook"); // stepKey: deleteProduct
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
	 * @Features({"Sales"})
	 * @Stories({"Storefront Customer Order History Comments"})
	 * @Severity(level = SeverityLevel::TRIVIAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function StorefrontVerifyOrderHistoryCommentsTest(AcceptanceTester $I)
	{
		$I->comment("Login as customer");
		$I->comment("Entering Action Group [loginToStorefrontAccount] LoginToStorefrontActionGroup");
		$I->amOnPage("/customer/account/login/"); // stepKey: amOnSignInPageLoginToStorefrontAccount
		$I->waitForPageLoad(30); // stepKey: waitPageFullyLoadedLoginToStorefrontAccount
		$I->waitForElementVisible("#email", 30); // stepKey: waitFormAppearsLoginToStorefrontAccount
		$I->fillField("#email", $I->retrieveEntityField('createCustomer', 'email', 'test')); // stepKey: fillEmailLoginToStorefrontAccount
		$I->fillField("#pass", $I->retrieveEntityField('createCustomer', 'password', 'test')); // stepKey: fillPasswordLoginToStorefrontAccount
		$I->click("#send2"); // stepKey: clickSignInAccountButtonLoginToStorefrontAccount
		$I->waitForPageLoad(30); // stepKey: clickSignInAccountButtonLoginToStorefrontAccountWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCustomerLoggedInLoginToStorefrontAccount
		$I->comment("Exiting Action Group [loginToStorefrontAccount] LoginToStorefrontActionGroup");
		$I->comment("Add product to cart");
		$I->comment("Entering Action Group [addSimpleProductToCart] StorefrontAddSimpleProductWithQtyActionGroup");
		$I->amOnPage("/" . $I->retrieveEntityField('createProduct', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: goToProductPageAddSimpleProductToCart
		$I->fillField("input.input-text.qty", "1"); // stepKey: fillProductQtyAddSimpleProductToCart
		$I->waitForPageLoad(30); // stepKey: fillProductQtyAddSimpleProductToCartWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForProductPageAddSimpleProductToCart
		$I->click("button.action.tocart.primary"); // stepKey: addToCartAddSimpleProductToCart
		$I->waitForPageLoad(30); // stepKey: addToCartAddSimpleProductToCartWaitForPageLoad
		$I->waitForElementNotVisible("//button/span[text()='Adding...']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddingAddSimpleProductToCart
		$I->waitForElementNotVisible("//button/span[text()='Added']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddedAddSimpleProductToCart
		$I->waitForElementVisible("//button/span[text()='Add to Cart']", 30); // stepKey: waitForElementVisibleAddToCartButtonTitleIsAddToCartAddSimpleProductToCart
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAddSimpleProductToCart
		$I->waitForElementVisible("div.message-success.success.message", 30); // stepKey: waitForProductAddedMessageAddSimpleProductToCart
		$I->see("You added " . $I->retrieveEntityField('createProduct', 'name', 'test') . " to your shopping cart.", "div.message-success.success.message"); // stepKey: seeAddToCartSuccessMessageAddSimpleProductToCart
		$I->comment("Exiting Action Group [addSimpleProductToCart] StorefrontAddSimpleProductWithQtyActionGroup");
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
		$I->comment("Entering Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsAdmin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginAsAdmin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginAsAdmin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsAdmin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsAdminWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsAdmin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsAdmin
		$I->comment("Exiting Action Group [loginAsAdmin] AdminLoginActionGroup");
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
		$I->comment("Entering Action Group [fillAndSaveOrderComments] AdminSalesOrderCommentsActionGroup");
		$I->fillField("#history_comment", "<a href=\"https://business.adobe.com/products/magento/magento-commerce.html\">Testing Html Tags</a>"); // stepKey: fillCommentFillAndSaveOrderComments
		$I->checkOption("#history_visible"); // stepKey: checkVisibleOnStoreFrontFillAndSaveOrderComments
		$I->click(".order-history-comments-actions>button"); // stepKey: clickSaveCommentButtonFillAndSaveOrderComments
		$I->waitForPageLoad(30); // stepKey: waitForSaveCommentsFillAndSaveOrderComments
		$I->comment("Exiting Action Group [fillAndSaveOrderComments] AdminSalesOrderCommentsActionGroup");
		$I->comment("Entering Action Group [navigateToCustomerDashboardPage] StorefrontOpenMyAccountPageActionGroup");
		$I->amOnPage("/customer/account/"); // stepKey: goToMyAccountPageNavigateToCustomerDashboardPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadNavigateToCustomerDashboardPage
		$I->comment("Exiting Action Group [navigateToCustomerDashboardPage] StorefrontOpenMyAccountPageActionGroup");
		$I->comment("Entering Action Group [clickViewOrder] StorefrontClickViewOrderLinkOnMyOrdersPageActionGroup");
		$I->click("//td[contains(concat(' ',normalize-space(@class),' '),' col actions ')]/a[contains(concat(' ',normalize-space(@class),' '),' action view ')]"); // stepKey: clickViewOrderClickViewOrder
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadedClickViewOrder
		$I->comment("Exiting Action Group [clickViewOrder] StorefrontClickViewOrderLinkOnMyOrdersPageActionGroup");
		$I->dontSee("a href", ".block-order-details-comments .comment-content"); // stepKey: dontSeeExposedHtmlCode
	}
}
