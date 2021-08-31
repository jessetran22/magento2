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
 * @Title("[NO TESTCASEID]: Verify banner is persistent and appears during all page views in session")
 * @Description("Banner is persistent and appears on all pages in session<h3>Test files</h3>app/code/Magento/LoginAsCustomer/Test/Mftf/Test/StorefrontLoginAsCustomerBannerPresentOnAllPagesInSessionTest.xml<br>")
 * @group login_as_customer
 */
class StorefrontLoginAsCustomerBannerPresentOnAllPagesInSessionTestCest
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
		$I->createEntity("createSimpleProduct", "hook", "SimpleProduct", ["createCategory"], []); // stepKey: createSimpleProduct
		$I->createEntity("createCustomer", "hook", "Simple_US_Customer_Assistance_Allowed", [], []); // stepKey: createCustomer
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
		$I->closeTab(); // stepKey: closeLoginAsCustomerTab
		$I->comment("Entering Action Group [logout] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageLogout
		$I->comment("Exiting Action Group [logout] AdminLogoutActionGroup");
		$I->comment("Customer Log Out");
		$I->comment("Entering Action Group [customerLogout] StorefrontCustomerLogoutActionGroup");
		$I->amOnPage("customer/account/logout/"); // stepKey: storefrontSignOutCustomerLogout
		$I->waitForPageLoad(30); // stepKey: waitForSignOutCustomerLogout
		$I->comment("Exiting Action Group [customerLogout] StorefrontCustomerLogoutActionGroup");
		$I->deleteEntity("createCustomer", "hook"); // stepKey: deleteCustomer
		$I->deleteEntity("createCategory", "hook"); // stepKey: deleteCategory
		$I->deleteEntity("createSimpleProduct", "hook"); // stepKey: deleteProduct
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
	 * @Stories({"Notification banner appears on all pages in session"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function StorefrontLoginAsCustomerBannerPresentOnAllPagesInSessionTest(AcceptanceTester $I)
	{
		$I->comment("Admin Login as Customer from Customer page and assert notification banner");
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
		$I->comment("Go to Wishlist and assert notification banner");
		$I->amOnPage("/wishlist/"); // stepKey: amOnWishListPage
		$I->waitForPageLoad(30); // stepKey: waitForWishlistPageLoad
		$I->comment("Entering Action Group [assertNotificationBannerOnWishList] StorefrontAssertLoginAsCustomerNotificationBannerActionGroup");
		$I->waitForElementVisible("//div[contains(@class, 'lac-notification')]//div[contains(@class, 'lac-notification-text')]/span", 30); // stepKey: waitForNotificationBannerAssertNotificationBannerOnWishList
		$I->waitForPageLoad(30); // stepKey: waitForNotificationBannerAssertNotificationBannerOnWishListWaitForPageLoad
		$I->see("You are connected as " . $I->retrieveEntityField('createCustomer', 'firstname', 'test') . " " . $I->retrieveEntityField('createCustomer', 'lastname', 'test') . " on Main Website", "//div[contains(@class, 'lac-notification')]//div[contains(@class, 'lac-notification-text')]/span"); // stepKey: assertCorrectNotificationBannerMessageAssertNotificationBannerOnWishList
		$I->waitForPageLoad(30); // stepKey: assertCorrectNotificationBannerMessageAssertNotificationBannerOnWishListWaitForPageLoad
		$I->seeElement("//div[contains(@class, 'lac-notification')]//div[contains(@class, 'lac-notification-links')]/a[contains(@class, 'lac-notification-close-link')]"); // stepKey: assertCloseNotificationBannerPresentAssertNotificationBannerOnWishList
		$I->waitForPageLoad(30); // stepKey: assertCloseNotificationBannerPresentAssertNotificationBannerOnWishListWaitForPageLoad
		$I->comment("Exiting Action Group [assertNotificationBannerOnWishList] StorefrontAssertLoginAsCustomerNotificationBannerActionGroup");
		$I->comment("Go to category page and assert notification banner");
		$I->amOnPage("/" . $I->retrieveEntityField('createCategory', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: navigateToCategoryPage
		$I->comment("Entering Action Group [assertNotificationBannerOnCategoryPage] StorefrontAssertLoginAsCustomerNotificationBannerActionGroup");
		$I->waitForElementVisible("//div[contains(@class, 'lac-notification')]//div[contains(@class, 'lac-notification-text')]/span", 30); // stepKey: waitForNotificationBannerAssertNotificationBannerOnCategoryPage
		$I->waitForPageLoad(30); // stepKey: waitForNotificationBannerAssertNotificationBannerOnCategoryPageWaitForPageLoad
		$I->see("You are connected as " . $I->retrieveEntityField('createCustomer', 'firstname', 'test') . " " . $I->retrieveEntityField('createCustomer', 'lastname', 'test') . " on Main Website", "//div[contains(@class, 'lac-notification')]//div[contains(@class, 'lac-notification-text')]/span"); // stepKey: assertCorrectNotificationBannerMessageAssertNotificationBannerOnCategoryPage
		$I->waitForPageLoad(30); // stepKey: assertCorrectNotificationBannerMessageAssertNotificationBannerOnCategoryPageWaitForPageLoad
		$I->seeElement("//div[contains(@class, 'lac-notification')]//div[contains(@class, 'lac-notification-links')]/a[contains(@class, 'lac-notification-close-link')]"); // stepKey: assertCloseNotificationBannerPresentAssertNotificationBannerOnCategoryPage
		$I->waitForPageLoad(30); // stepKey: assertCloseNotificationBannerPresentAssertNotificationBannerOnCategoryPageWaitForPageLoad
		$I->comment("Exiting Action Group [assertNotificationBannerOnCategoryPage] StorefrontAssertLoginAsCustomerNotificationBannerActionGroup");
		$I->comment("Go to product page and assert notification banner");
		$I->comment("Entering Action Group [openProductPage] OpenStoreFrontProductPageActionGroup");
		$I->amOnPage("/" . $I->retrieveEntityField('createSimpleProduct', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: amOnProductPageOpenProductPage
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoadOpenProductPage
		$I->comment("Exiting Action Group [openProductPage] OpenStoreFrontProductPageActionGroup");
		$I->comment("Entering Action Group [assertNotificationBannerOnProductPage] StorefrontAssertLoginAsCustomerNotificationBannerActionGroup");
		$I->waitForElementVisible("//div[contains(@class, 'lac-notification')]//div[contains(@class, 'lac-notification-text')]/span", 30); // stepKey: waitForNotificationBannerAssertNotificationBannerOnProductPage
		$I->waitForPageLoad(30); // stepKey: waitForNotificationBannerAssertNotificationBannerOnProductPageWaitForPageLoad
		$I->see("You are connected as " . $I->retrieveEntityField('createCustomer', 'firstname', 'test') . " " . $I->retrieveEntityField('createCustomer', 'lastname', 'test') . " on Main Website", "//div[contains(@class, 'lac-notification')]//div[contains(@class, 'lac-notification-text')]/span"); // stepKey: assertCorrectNotificationBannerMessageAssertNotificationBannerOnProductPage
		$I->waitForPageLoad(30); // stepKey: assertCorrectNotificationBannerMessageAssertNotificationBannerOnProductPageWaitForPageLoad
		$I->seeElement("//div[contains(@class, 'lac-notification')]//div[contains(@class, 'lac-notification-links')]/a[contains(@class, 'lac-notification-close-link')]"); // stepKey: assertCloseNotificationBannerPresentAssertNotificationBannerOnProductPage
		$I->waitForPageLoad(30); // stepKey: assertCloseNotificationBannerPresentAssertNotificationBannerOnProductPageWaitForPageLoad
		$I->comment("Exiting Action Group [assertNotificationBannerOnProductPage] StorefrontAssertLoginAsCustomerNotificationBannerActionGroup");
		$I->comment("Add product to cart and assert notification banner");
		$I->comment("Entering Action Group [addProductToCart] StorefrontAddProductToCartActionGroup");
		$I->click("button#product-addtocart-button"); // stepKey: clickAddToCartAddProductToCart
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAddProductToCart
		$I->waitForElementVisible("div.message-success", 30); // stepKey: waitForSuccessMessageAddProductToCart
		$I->see("You added " . $I->retrieveEntityField('createSimpleProduct', 'name', 'test') . " to your shopping cart.", ".page.messages"); // stepKey: assertSuccessMessageAddProductToCart
		$I->waitForPageLoad(30); // stepKey: assertSuccessMessageAddProductToCartWaitForPageLoad
		$I->seeLink("shopping cart", getenv("MAGENTO_BASE_URL") . "checkout/cart/"); // stepKey: assertLinkToShoppingCartAddProductToCart
		$I->waitForText("1", 30, "//header//div[contains(@class, 'minicart-wrapper')]//a[contains(@class, 'showcart')]//span[@class='counter-number']"); // stepKey: assertProductCountAddProductToCart
		$I->comment("Exiting Action Group [addProductToCart] StorefrontAddProductToCartActionGroup");
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
		$I->comment("Entering Action Group [assertNotificationBannerOnCartPage] StorefrontAssertLoginAsCustomerNotificationBannerActionGroup");
		$I->waitForElementVisible("//div[contains(@class, 'lac-notification')]//div[contains(@class, 'lac-notification-text')]/span", 30); // stepKey: waitForNotificationBannerAssertNotificationBannerOnCartPage
		$I->waitForPageLoad(30); // stepKey: waitForNotificationBannerAssertNotificationBannerOnCartPageWaitForPageLoad
		$I->see("You are connected as " . $I->retrieveEntityField('createCustomer', 'firstname', 'test') . " " . $I->retrieveEntityField('createCustomer', 'lastname', 'test') . " on Main Website", "//div[contains(@class, 'lac-notification')]//div[contains(@class, 'lac-notification-text')]/span"); // stepKey: assertCorrectNotificationBannerMessageAssertNotificationBannerOnCartPage
		$I->waitForPageLoad(30); // stepKey: assertCorrectNotificationBannerMessageAssertNotificationBannerOnCartPageWaitForPageLoad
		$I->seeElement("//div[contains(@class, 'lac-notification')]//div[contains(@class, 'lac-notification-links')]/a[contains(@class, 'lac-notification-close-link')]"); // stepKey: assertCloseNotificationBannerPresentAssertNotificationBannerOnCartPage
		$I->waitForPageLoad(30); // stepKey: assertCloseNotificationBannerPresentAssertNotificationBannerOnCartPageWaitForPageLoad
		$I->comment("Exiting Action Group [assertNotificationBannerOnCartPage] StorefrontAssertLoginAsCustomerNotificationBannerActionGroup");
		$I->comment("Proceed to checkout and assert notification banner");
		$I->comment("Entering Action Group [clickProceedToCheckout] StorefrontClickProceedToCheckoutActionGroup");
		$I->click(".action.primary.checkout span"); // stepKey: goToCheckoutClickProceedToCheckout
		$I->waitForPageLoad(30); // stepKey: goToCheckoutClickProceedToCheckoutWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadClickProceedToCheckout
		$I->comment("Exiting Action Group [clickProceedToCheckout] StorefrontClickProceedToCheckoutActionGroup");
		$I->comment("Adding the comment to replace waitForProceedToCheckout action for preserving Backward Compatibility");
		$I->comment("Entering Action Group [assertNotificationBannerOnCheckoutPage] StorefrontAssertLoginAsCustomerNotificationBannerActionGroup");
		$I->waitForElementVisible("//div[contains(@class, 'lac-notification')]//div[contains(@class, 'lac-notification-text')]/span", 30); // stepKey: waitForNotificationBannerAssertNotificationBannerOnCheckoutPage
		$I->waitForPageLoad(30); // stepKey: waitForNotificationBannerAssertNotificationBannerOnCheckoutPageWaitForPageLoad
		$I->see("You are connected as " . $I->retrieveEntityField('createCustomer', 'firstname', 'test') . " " . $I->retrieveEntityField('createCustomer', 'lastname', 'test') . " on Main Website", "//div[contains(@class, 'lac-notification')]//div[contains(@class, 'lac-notification-text')]/span"); // stepKey: assertCorrectNotificationBannerMessageAssertNotificationBannerOnCheckoutPage
		$I->waitForPageLoad(30); // stepKey: assertCorrectNotificationBannerMessageAssertNotificationBannerOnCheckoutPageWaitForPageLoad
		$I->seeElement("//div[contains(@class, 'lac-notification')]//div[contains(@class, 'lac-notification-links')]/a[contains(@class, 'lac-notification-close-link')]"); // stepKey: assertCloseNotificationBannerPresentAssertNotificationBannerOnCheckoutPage
		$I->waitForPageLoad(30); // stepKey: assertCloseNotificationBannerPresentAssertNotificationBannerOnCheckoutPageWaitForPageLoad
		$I->comment("Exiting Action Group [assertNotificationBannerOnCheckoutPage] StorefrontAssertLoginAsCustomerNotificationBannerActionGroup");
		$I->comment("Assert notification banner before place order");
		$I->comment("Entering Action Group [selectFlatRateShippingMethod] CheckoutSelectFlatRateShippingMethodActionGroup");
		$I->conditionalClick("//div[@id='checkout-shipping-method-load']//td[contains(., 'Flat Rate')]/..//input", "//div[@id='checkout-shipping-method-load']//td[contains(., 'Flat Rate')]/..//input", true); // stepKey: selectFlatRateShippingMethodSelectFlatRateShippingMethod
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskForNextButtonSelectFlatRateShippingMethod
		$I->comment("Exiting Action Group [selectFlatRateShippingMethod] CheckoutSelectFlatRateShippingMethodActionGroup");
		$I->waitForElementVisible("button.button.action.continue.primary", 30); // stepKey: waitForNextButton
		$I->waitForPageLoad(30); // stepKey: waitForNextButtonWaitForPageLoad
		$I->click("button.button.action.continue.primary"); // stepKey: clickNext
		$I->waitForPageLoad(30); // stepKey: clickNextWaitForPageLoad
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskAfterClickNext
		$I->comment("Entering Action Group [assertNotificationBannerBeforePlaceOrder] StorefrontAssertLoginAsCustomerNotificationBannerActionGroup");
		$I->waitForElementVisible("//div[contains(@class, 'lac-notification')]//div[contains(@class, 'lac-notification-text')]/span", 30); // stepKey: waitForNotificationBannerAssertNotificationBannerBeforePlaceOrder
		$I->waitForPageLoad(30); // stepKey: waitForNotificationBannerAssertNotificationBannerBeforePlaceOrderWaitForPageLoad
		$I->see("You are connected as " . $I->retrieveEntityField('createCustomer', 'firstname', 'test') . " " . $I->retrieveEntityField('createCustomer', 'lastname', 'test') . " on Main Website", "//div[contains(@class, 'lac-notification')]//div[contains(@class, 'lac-notification-text')]/span"); // stepKey: assertCorrectNotificationBannerMessageAssertNotificationBannerBeforePlaceOrder
		$I->waitForPageLoad(30); // stepKey: assertCorrectNotificationBannerMessageAssertNotificationBannerBeforePlaceOrderWaitForPageLoad
		$I->seeElement("//div[contains(@class, 'lac-notification')]//div[contains(@class, 'lac-notification-links')]/a[contains(@class, 'lac-notification-close-link')]"); // stepKey: assertCloseNotificationBannerPresentAssertNotificationBannerBeforePlaceOrder
		$I->waitForPageLoad(30); // stepKey: assertCloseNotificationBannerPresentAssertNotificationBannerBeforePlaceOrderWaitForPageLoad
		$I->comment("Exiting Action Group [assertNotificationBannerBeforePlaceOrder] StorefrontAssertLoginAsCustomerNotificationBannerActionGroup");
		$I->comment("Assert notification banner after place order");
		$I->comment("Entering Action Group [selectPaymentMethod] CheckoutSelectCheckMoneyOrderPaymentActionGroup");
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskSelectPaymentMethod
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadSelectPaymentMethod
		$I->conditionalClick("//div[@id='checkout-payment-method-load']//div[@class='payment-method']//label//span[contains(., 'Check / Money order')]/../..//input", "//div[@id='checkout-payment-method-load']//div[@class='payment-method']//label//span[contains(., 'Check / Money order')]/../..//input", true); // stepKey: selectCheckmoPaymentMethodSelectPaymentMethod
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskAfterPaymentMethodSelectionSelectPaymentMethod
		$I->comment("Exiting Action Group [selectPaymentMethod] CheckoutSelectCheckMoneyOrderPaymentActionGroup");
		$I->comment("Entering Action Group [customerPlaceOrder] CheckoutPlaceOrderActionGroup");
		$I->waitForElementVisible(".payment-method._active button.action.primary.checkout", 30); // stepKey: waitForPlaceOrderButtonCustomerPlaceOrder
		$I->waitForPageLoad(30); // stepKey: waitForPlaceOrderButtonCustomerPlaceOrderWaitForPageLoad
		$I->click(".payment-method._active button.action.primary.checkout"); // stepKey: clickPlaceOrderCustomerPlaceOrder
		$I->waitForPageLoad(30); // stepKey: clickPlaceOrderCustomerPlaceOrderWaitForPageLoad
		$I->see("Your order number is:", "div.checkout-success"); // stepKey: seeOrderNumberCustomerPlaceOrder
		$I->see("We'll email you an order confirmation with details and tracking info.", "div.checkout-success"); // stepKey: seeEmailYouCustomerPlaceOrder
		$I->comment("Exiting Action Group [customerPlaceOrder] CheckoutPlaceOrderActionGroup");
		$I->comment("Entering Action Group [assertNotificationBannerAfterPlaceOrder] StorefrontAssertLoginAsCustomerNotificationBannerActionGroup");
		$I->waitForElementVisible("//div[contains(@class, 'lac-notification')]//div[contains(@class, 'lac-notification-text')]/span", 30); // stepKey: waitForNotificationBannerAssertNotificationBannerAfterPlaceOrder
		$I->waitForPageLoad(30); // stepKey: waitForNotificationBannerAssertNotificationBannerAfterPlaceOrderWaitForPageLoad
		$I->see("You are connected as " . $I->retrieveEntityField('createCustomer', 'firstname', 'test') . " " . $I->retrieveEntityField('createCustomer', 'lastname', 'test') . " on Main Website", "//div[contains(@class, 'lac-notification')]//div[contains(@class, 'lac-notification-text')]/span"); // stepKey: assertCorrectNotificationBannerMessageAssertNotificationBannerAfterPlaceOrder
		$I->waitForPageLoad(30); // stepKey: assertCorrectNotificationBannerMessageAssertNotificationBannerAfterPlaceOrderWaitForPageLoad
		$I->seeElement("//div[contains(@class, 'lac-notification')]//div[contains(@class, 'lac-notification-links')]/a[contains(@class, 'lac-notification-close-link')]"); // stepKey: assertCloseNotificationBannerPresentAssertNotificationBannerAfterPlaceOrder
		$I->waitForPageLoad(30); // stepKey: assertCloseNotificationBannerPresentAssertNotificationBannerAfterPlaceOrderWaitForPageLoad
		$I->comment("Exiting Action Group [assertNotificationBannerAfterPlaceOrder] StorefrontAssertLoginAsCustomerNotificationBannerActionGroup");
	}
}
