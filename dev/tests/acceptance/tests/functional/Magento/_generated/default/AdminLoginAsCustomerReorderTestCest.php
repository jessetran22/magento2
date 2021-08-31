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
 * @Title("[NO TESTCASEID]: Admin user login as customer and reorder existing order")
 * @Description("Verify that admin user can reorder using 'Login as customer' functionality<h3>Test files</h3>app/code/Magento/LoginAsCustomer/Test/Mftf/Test/AdminLoginAsCustomerReorderTest.xml<br>")
 * @group login_as_customer
 */
class AdminLoginAsCustomerReorderTestCest
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
		$enableLoginAsCustomerAutoDetection = $I->magentoCLI("config:set login_as_customer/general/store_view_manual_choice_enabled 0", 60); // stepKey: enableLoginAsCustomerAutoDetection
		$I->comment($enableLoginAsCustomerAutoDetection);
		$I->comment("Adding the comment to replace 'cache:flush' command for preserving Backward Compatibility");
		$I->createEntity("createCategory", "hook", "_defaultCategory", [], []); // stepKey: createCategory
		$I->createEntity("createProduct", "hook", "SimpleProduct", ["createCategory"], []); // stepKey: createProduct
		$I->createEntity("createCustomer", "hook", "Simple_US_Customer_Assistance_Allowed", [], []); // stepKey: createCustomer
		$I->comment("Create new User");
		$I->comment("Entering Action Group [adminLogin] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminAdminLogin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameAdminLogin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordAdminLogin
		$I->click(".actions .action-primary"); // stepKey: clickLoginAdminLogin
		$I->waitForPageLoad(30); // stepKey: clickLoginAdminLoginWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleAdminLogin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationAdminLogin
		$I->comment("Exiting Action Group [adminLogin] AdminLoginActionGroup");
		$I->comment("Entering Action Group [createAdminUser] AdminCreateUserWithRoleActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/user/new"); // stepKey: navigateToNewUserCreateAdminUser
		$I->waitForPageLoad(30); // stepKey: waitForUsersPageCreateAdminUser
		$I->fillField("#user_username", "AdminUser" . msq("activeAdmin")); // stepKey: enterUserNameCreateAdminUser
		$I->fillField("#user_firstname", "FirstName" . msq("activeAdmin")); // stepKey: enterFirstNameCreateAdminUser
		$I->fillField("#user_lastname", "LastName" . msq("activeAdmin")); // stepKey: enterLastNameCreateAdminUser
		$I->fillField("#user_email", "AdminUser" . msq("activeAdmin") . "@magento.com"); // stepKey: enterEmailCreateAdminUser
		$I->fillField("#user_password", "123123q"); // stepKey: enterPasswordCreateAdminUser
		$I->fillField("#user_confirmation", "123123q"); // stepKey: confirmPasswordCreateAdminUser
		$I->fillField("#user_current_password", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: enterCurrentPasswordCreateAdminUser
		$I->scrollToTopOfPage(); // stepKey: scrollToTopOfPageCreateAdminUser
		$I->click("#page_tabs_roles_section"); // stepKey: clickUserRoleCreateAdminUser
		$I->click("//tr//td[contains(text(), 'Administrators')]"); // stepKey: chooseRoleCreateAdminUser
		$I->click("#save"); // stepKey: clickSaveUserCreateAdminUser
		$I->waitForPageLoad(30); // stepKey: waitForSaveTheUserCreateAdminUser
		$I->see("You saved the user."); // stepKey: seeSuccessMessageCreateAdminUser
		$I->comment("Exiting Action Group [createAdminUser] AdminCreateUserWithRoleActionGroup");
		$I->comment("Entering Action Group [logoutMasterAdmin] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageLogoutMasterAdmin
		$I->comment("Exiting Action Group [logoutMasterAdmin] AdminLogoutActionGroup");
		$I->comment("Login as new User");
		$I->comment("Entering Action Group [loginToNewAdmin] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginToNewAdmin
		$I->fillField("#username", "AdminUser" . msq("activeAdmin")); // stepKey: fillUsernameLoginToNewAdmin
		$I->fillField("#login", "123123q"); // stepKey: fillPasswordLoginToNewAdmin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginToNewAdmin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginToNewAdminWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginToNewAdmin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginToNewAdmin
		$I->comment("Exiting Action Group [loginToNewAdmin] AdminLoginActionGroup");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->deleteEntity("createCustomer", "hook"); // stepKey: deleteCustomer
		$I->deleteEntity("createCategory", "hook"); // stepKey: deleteCategory
		$I->deleteEntity("createProduct", "hook"); // stepKey: deleteProduct
		$I->comment("Entering Action Group [logout] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageLogout
		$I->comment("Exiting Action Group [logout] AdminLogoutActionGroup");
		$I->comment("Delete new User");
		$I->comment("Entering Action Group [adminLogin] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminAdminLogin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameAdminLogin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordAdminLogin
		$I->click(".actions .action-primary"); // stepKey: clickLoginAdminLogin
		$I->waitForPageLoad(30); // stepKey: clickLoginAdminLoginWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleAdminLogin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationAdminLogin
		$I->comment("Exiting Action Group [adminLogin] AdminLoginActionGroup");
		$I->comment("Entering Action Group [deleteUser] AdminDeleteUserActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/user/"); // stepKey: amOnAdminUsersPageDeleteUser
		$I->waitForPageLoad(30); // stepKey: waitForAdminUserPageLoadDeleteUser
		$I->click("//td[contains(text(), 'AdminUser" . msq("activeAdmin") . "')]"); // stepKey: openTheUserDeleteUser
		$I->fillField("#user_current_password", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: TypeCurrentPasswordDeleteUser
		$I->scrollToTopOfPage(); // stepKey: scrollToTopDeleteUser
		$I->click("//button/span[contains(text(), 'Delete User')]"); // stepKey: clickToDeleteRoleDeleteUser
		$I->waitForElementVisible("//*[@class='action-primary action-accept']", 30); // stepKey: waitDeleteUser
		$I->click(".action-primary.action-accept"); // stepKey: clickToConfirmDeleteUser
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadDeleteUser
		$I->see("You deleted the user."); // stepKey: seeDeleteMessageForUserDeleteUser
		$I->comment("Exiting Action Group [deleteUser] AdminDeleteUserActionGroup");
		$I->comment("Entering Action Group [adminLogout] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageAdminLogout
		$I->comment("Exiting Action Group [adminLogout] AdminLogoutActionGroup");
		$disableLoginAsCustomer = $I->magentoCLI("config:set login_as_customer/general/enabled 0", 60); // stepKey: disableLoginAsCustomer
		$I->comment($disableLoginAsCustomer);
		$I->comment("Adding the comment to replace 'cache:flush' command for preserving Backward Compatibility");
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
	 * @Stories({"Place order and reorder"})
	 * @Severity(level = SeverityLevel::NORMAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminLoginAsCustomerReorderTest(AcceptanceTester $I)
	{
		$I->comment("Login to storefront as Customer");
		$I->comment("Entering Action Group [customerLogin] LoginToStorefrontActionGroup");
		$I->amOnPage("/customer/account/login/"); // stepKey: amOnSignInPageCustomerLogin
		$I->waitForPageLoad(30); // stepKey: waitPageFullyLoadedCustomerLogin
		$I->waitForElementVisible("#email", 30); // stepKey: waitFormAppearsCustomerLogin
		$I->fillField("#email", $I->retrieveEntityField('createCustomer', 'email', 'test')); // stepKey: fillEmailCustomerLogin
		$I->fillField("#pass", $I->retrieveEntityField('createCustomer', 'password', 'test')); // stepKey: fillPasswordCustomerLogin
		$I->click("#send2"); // stepKey: clickSignInAccountButtonCustomerLogin
		$I->waitForPageLoad(30); // stepKey: clickSignInAccountButtonCustomerLoginWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCustomerLoggedInCustomerLogin
		$I->comment("Exiting Action Group [customerLogin] LoginToStorefrontActionGroup");
		$I->comment("Place Order as Customer");
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
		$I->comment("Log out from storefront as Customer");
		$I->comment("Entering Action Group [customerLogOut] StorefrontCustomerLogoutActionGroup");
		$I->amOnPage("customer/account/logout/"); // stepKey: storefrontSignOutCustomerLogOut
		$I->waitForPageLoad(30); // stepKey: waitForSignOutCustomerLogOut
		$I->comment("Exiting Action Group [customerLogOut] StorefrontCustomerLogoutActionGroup");
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
		$I->comment("Make reorder");
		$I->comment("Entering Action Group [makeReorder] StorefrontCustomerReorderActionGroup");
		$I->amOnPage("/customer/account/"); // stepKey: goToCustomerDashboardPageMakeReorder
		$I->waitForPageLoad(30); // stepKey: waitForCustomerDashboardPageLoadMakeReorder
		$I->click("//div[@id='block-collapsible-nav']//a[text()='My Orders']"); // stepKey: navigateToOrdersMakeReorder
		$I->waitForPageLoad(60); // stepKey: navigateToOrdersMakeReorderWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForOrdersPageLoadMakeReorder
		$I->click("//td[contains(text(),'{$grabOrderId}')]/following-sibling::td[contains(@class,'col') and contains(@class,'actions')]/a[contains(@class, 'order')]"); // stepKey: clickReorderBtnMakeReorder
		$I->waitForPageLoad(30); // stepKey: clickReorderBtnMakeReorderWaitForPageLoad
		$I->comment("Exiting Action Group [makeReorder] StorefrontCustomerReorderActionGroup");
		$I->comment("Entering Action Group [placeReorder] PlaceOrderWithLoggedUserActionGroup");
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForCartTotalsLoadedPlaceReorder
		$I->waitForElementVisible(".grand.totals .amount .price", 30); // stepKey: waitForCartGrandTotalVisiblePlaceReorder
		$I->waitForElementVisible(".action.primary.checkout span", 30); // stepKey: waitProceedToCheckoutPlaceReorder
		$I->waitForPageLoad(30); // stepKey: waitProceedToCheckoutPlaceReorderWaitForPageLoad
		$I->click(".action.primary.checkout span"); // stepKey: clickProceedToCheckoutPlaceReorder
		$I->waitForPageLoad(30); // stepKey: clickProceedToCheckoutPlaceReorderWaitForPageLoad
		$I->click("//div[@id='checkout-shipping-method-load']//td[contains(., '')]/..//input"); // stepKey: selectShippingMethodPlaceReorder
		$I->waitForElement("button.button.action.continue.primary", 30); // stepKey: waitForNextButtonPlaceReorder
		$I->waitForPageLoad(30); // stepKey: waitForNextButtonPlaceReorderWaitForPageLoad
		$I->click("button.button.action.continue.primary"); // stepKey: clickNextPlaceReorder
		$I->waitForPageLoad(30); // stepKey: clickNextPlaceReorderWaitForPageLoad
		$I->waitForElement("//*[@id='checkout-payment-method-load']//div[@data-role='title']", 30); // stepKey: waitForPaymentSectionLoadedPlaceReorder
		$I->seeInCurrentUrl("/checkout/#payment"); // stepKey: assertCheckoutPaymentUrlPlaceReorder
		$I->waitForElementVisible(".payment-method._active button.action.primary.checkout", 30); // stepKey: waitForPlaceOrderButtonPlaceReorder
		$I->waitForPageLoad(30); // stepKey: waitForPlaceOrderButtonPlaceReorderWaitForPageLoad
		$I->click(".payment-method._active button.action.primary.checkout"); // stepKey: clickPlaceOrderPlaceReorder
		$I->waitForPageLoad(30); // stepKey: clickPlaceOrderPlaceReorderWaitForPageLoad
		$I->see("Thank you for your purchase!", ".page-title"); // stepKey: waitForLoadSuccessPagePlaceReorder
		$I->comment("Exiting Action Group [placeReorder] PlaceOrderWithLoggedUserActionGroup");
		$grabReorderId = $I->grabTextFrom(".order-number>strong"); // stepKey: grabReorderId
		$I->comment("Assert Storefront Order page contains message about Order created by a Store Administrator");
		$I->comment("Entering Action Group [verifyStorefrontMessageOrderCreatedByAdmin] StorefrontAssertContainsMessageOrderCreatedByAdminActionGroup");
		$I->amOnPage("sales/order/view/order_id/${grabReorderId}"); // stepKey: gotoOrderPageVerifyStorefrontMessageOrderCreatedByAdmin
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadVerifyStorefrontMessageOrderCreatedByAdmin
		$I->see("Order Placed by Store Administrator"); // stepKey: seeMessageOrderCreatedByAdminVerifyStorefrontMessageOrderCreatedByAdmin
		$I->comment("Exiting Action Group [verifyStorefrontMessageOrderCreatedByAdmin] StorefrontAssertContainsMessageOrderCreatedByAdminActionGroup");
		$I->comment("Assert Admin Order page contains message about Order created by a Store Administrator");
		$I->comment("Entering Action Group [verifyAdminMessageOrderCreatedByAdmin] AdminAssertContainsMessageOrderCreatedByAdminActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/sales/order/view/order_id/${grabReorderId}"); // stepKey: gotoOrderPageVerifyAdminMessageOrderCreatedByAdmin
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadVerifyAdminMessageOrderCreatedByAdmin
		$I->see("Order Placed by FirstName" . msq("activeAdmin") . " LastName" . msq("activeAdmin") . " using Login as Customer"); // stepKey: seeMessageOrderCreatedByAdminVerifyAdminMessageOrderCreatedByAdmin
		$I->comment("Exiting Action Group [verifyAdminMessageOrderCreatedByAdmin] AdminAssertContainsMessageOrderCreatedByAdminActionGroup");
	}
}
