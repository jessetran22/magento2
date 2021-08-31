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
 * @Title("MC-17461: Place an order with three different addresses")
 * @Description("Place an order with three different addresses<h3>Test files</h3>app/code/Magento/Multishipping/Test/Mftf/Test/StorefrontCheckoutWithMultipleAddressesTest.xml<br>")
 * @TestCaseId("MC-17461")
 * @group Multishipment
 */
class StorefrontCheckoutWithMultipleAddressesTestCest
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
		$I->comment("Entering Action Group [login] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLogin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLogin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLogin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLogin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLogin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLogin
		$I->comment("Exiting Action Group [login] AdminLoginActionGroup");
		$I->comment("Create simple products");
		$I->createEntity("createCategory", "hook", "SimpleSubCategory", [], []); // stepKey: createCategory
		$I->createEntity("firstProduct", "hook", "SimpleProduct", ["createCategory"], []); // stepKey: firstProduct
		$I->createEntity("secondProduct", "hook", "SimpleProduct", ["createCategory"], []); // stepKey: secondProduct
		$I->createEntity("createCustomerWithMultipleAddresses", "hook", "Customer_US_UK_DE", [], []); // stepKey: createCustomerWithMultipleAddresses
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Delete created data");
		$I->comment("Entering Action Group [logout] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageLogout
		$I->comment("Exiting Action Group [logout] AdminLogoutActionGroup");
		$I->deleteEntity("firstProduct", "hook"); // stepKey: deleteFirstProduct
		$I->deleteEntity("secondProduct", "hook"); // stepKey: deleteSecondProduct
		$I->deleteEntity("createCategory", "hook"); // stepKey: deleteCategory
		$I->deleteEntity("createCustomerWithMultipleAddresses", "hook"); // stepKey: deleteCustomer
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
	 * @Features({"Multishipping"})
	 * @Stories({"Multiple Shipping"})
	 * @Severity(level = SeverityLevel::NORMAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function StorefrontCheckoutWithMultipleAddressesTest(AcceptanceTester $I)
	{
		$I->comment("Login to the Storefront as created customer");
		$I->comment("Entering Action Group [loginAsCustomer] LoginToStorefrontActionGroup");
		$I->amOnPage("/customer/account/login/"); // stepKey: amOnSignInPageLoginAsCustomer
		$I->waitForPageLoad(30); // stepKey: waitPageFullyLoadedLoginAsCustomer
		$I->waitForElementVisible("#email", 30); // stepKey: waitFormAppearsLoginAsCustomer
		$I->fillField("#email", $I->retrieveEntityField('createCustomerWithMultipleAddresses', 'email', 'test')); // stepKey: fillEmailLoginAsCustomer
		$I->fillField("#pass", $I->retrieveEntityField('createCustomerWithMultipleAddresses', 'password', 'test')); // stepKey: fillPasswordLoginAsCustomer
		$I->click("#send2"); // stepKey: clickSignInAccountButtonLoginAsCustomer
		$I->waitForPageLoad(30); // stepKey: clickSignInAccountButtonLoginAsCustomerWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCustomerLoggedInLoginAsCustomer
		$I->comment("Exiting Action Group [loginAsCustomer] LoginToStorefrontActionGroup");
		$I->comment("Open the first product page");
		$I->comment("Entering Action Group [goToFirstProductPage] StorefrontOpenProductPageActionGroup");
		$I->amOnPage("/" . $I->retrieveEntityField('firstProduct', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: openProductPageGoToFirstProductPage
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoadedGoToFirstProductPage
		$I->comment("Exiting Action Group [goToFirstProductPage] StorefrontOpenProductPageActionGroup");
		$I->comment("Add the first product to the Shopping Cart");
		$I->comment("Entering Action Group [addFirstProductToCart] AddProductWithQtyToCartFromStorefrontProductPageActionGroup");
		$I->fillField("#qty", "1"); // stepKey: fillProductQuantityAddFirstProductToCart
		$I->click("#product-addtocart-button"); // stepKey: addToCartAddFirstProductToCart
		$I->waitForPageLoad(60); // stepKey: addToCartAddFirstProductToCartWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForAddToCartAddFirstProductToCart
		$I->waitForElementNotVisible("//button/span[text()='Adding...']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddingAddFirstProductToCart
		$I->waitForElementNotVisible("//button/span[text()='Added']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddedAddFirstProductToCart
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAddFirstProductToCart
		$I->waitForElementVisible("div.message-success.success.message", 30); // stepKey: waitForSuccessMessageAddFirstProductToCart
		$I->see("You added " . $I->retrieveEntityField('firstProduct', 'name', 'test') . " to your shopping cart.", "div.message-success.success.message"); // stepKey: seeAddToCartSuccessMessageAddFirstProductToCart
		$I->comment("Exiting Action Group [addFirstProductToCart] AddProductWithQtyToCartFromStorefrontProductPageActionGroup");
		$I->comment("Open the second product page");
		$I->comment("Entering Action Group [goToSecondProductPage] StorefrontOpenProductPageActionGroup");
		$I->amOnPage("/" . $I->retrieveEntityField('secondProduct', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: openProductPageGoToSecondProductPage
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoadedGoToSecondProductPage
		$I->comment("Exiting Action Group [goToSecondProductPage] StorefrontOpenProductPageActionGroup");
		$I->comment("Add the second product to the Shopping Cart");
		$I->comment("Entering Action Group [addSecondProductToCart] AddProductWithQtyToCartFromStorefrontProductPageActionGroup");
		$I->fillField("#qty", "1"); // stepKey: fillProductQuantityAddSecondProductToCart
		$I->click("#product-addtocart-button"); // stepKey: addToCartAddSecondProductToCart
		$I->waitForPageLoad(60); // stepKey: addToCartAddSecondProductToCartWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForAddToCartAddSecondProductToCart
		$I->waitForElementNotVisible("//button/span[text()='Adding...']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddingAddSecondProductToCart
		$I->waitForElementNotVisible("//button/span[text()='Added']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddedAddSecondProductToCart
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAddSecondProductToCart
		$I->waitForElementVisible("div.message-success.success.message", 30); // stepKey: waitForSuccessMessageAddSecondProductToCart
		$I->see("You added " . $I->retrieveEntityField('secondProduct', 'name', 'test') . " to your shopping cart.", "div.message-success.success.message"); // stepKey: seeAddToCartSuccessMessageAddSecondProductToCart
		$I->comment("Exiting Action Group [addSecondProductToCart] AddProductWithQtyToCartFromStorefrontProductPageActionGroup");
		$I->comment("Go to Cart");
		$I->comment("Entering Action Group [openCart] StorefrontOpenCartFromMinicartActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollToTopOfThePageOpenCart
		$I->waitForElement("a.showcart", 30); // stepKey: waitForShowMinicartOpenCart
		$I->waitForPageLoad(60); // stepKey: waitForShowMinicartOpenCartWaitForPageLoad
		$I->waitForElement(".action.viewcart", 30); // stepKey: waitForCartLinkOpenCart
		$I->waitForPageLoad(30); // stepKey: waitForCartLinkOpenCartWaitForPageLoad
		$I->click("a.showcart"); // stepKey: clickShowMinicartOpenCart
		$I->waitForPageLoad(60); // stepKey: clickShowMinicartOpenCartWaitForPageLoad
		$I->click(".action.viewcart"); // stepKey: clickCartOpenCart
		$I->waitForPageLoad(30); // stepKey: clickCartOpenCartWaitForPageLoad
		$I->comment("Exiting Action Group [openCart] StorefrontOpenCartFromMinicartActionGroup");
		$I->comment("Check Out with Multiple Addresses");
		$I->comment("Entering Action Group [checkoutWithMultipleAddresses] StorefrontCheckoutWithMultipleAddressesActionGroup");
		$I->click("//span[text()='Check Out with Multiple Addresses']"); // stepKey: clickOnCheckoutWithMultipleAddressesCheckoutWithMultipleAddresses
		$I->waitForPageLoad(30); // stepKey: waitForMultipleAddressPageLoadCheckoutWithMultipleAddresses
		$I->comment("Exiting Action Group [checkoutWithMultipleAddresses] StorefrontCheckoutWithMultipleAddressesActionGroup");
		$I->comment("Select different addresses and click 'Go to Shipping Information'");
		$I->comment("Entering Action Group [selectFirstAddress] StorefrontSelectAddressActionGroup");
		$I->selectOption("(//table[@id='multiship-addresses-table'] //div[@class='field address'] //select)[1]", "John Doe, 368 Broadway St. 113, New York, New York 10001, United States"); // stepKey: selectShippingAddressSelectFirstAddress
		$I->comment("Exiting Action Group [selectFirstAddress] StorefrontSelectAddressActionGroup");
		$I->comment("Entering Action Group [selectSecondAddress] StorefrontSelectAddressActionGroup");
		$I->selectOption("(//table[@id='multiship-addresses-table'] //div[@class='field address'] //select)[2]", "John Doe, Augsburger Strabe 41, Berlin,  10789, Germany"); // stepKey: selectShippingAddressSelectSecondAddress
		$I->comment("Exiting Action Group [selectSecondAddress] StorefrontSelectAddressActionGroup");
		$I->comment("Entering Action Group [saveAddresses] StorefrontSaveAddressActionGroup");
		$I->click("//button[@class='action update']"); // stepKey: clickOnUpdateAddressSaveAddresses
		$I->waitForPageLoad(90); // stepKey: waitForShippingInformationAfterUpdatedSaveAddresses
		$I->click("//span[text()='Go to Shipping Information']"); // stepKey: goToShippingInformationSaveAddresses
		$I->waitForPageLoad(30); // stepKey: waitForShippingPageLoadSaveAddresses
		$I->comment("Exiting Action Group [saveAddresses] StorefrontSaveAddressActionGroup");
		$I->comment("Click 'Continue to Billing Information'");
		$I->comment("Entering Action Group [useDefaultShippingMethod] StorefrontLeaveDefaultShippingMethodsAndGoToBillingInfoActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForShippingInfoUseDefaultShippingMethod
		$I->click(".action.primary.continue"); // stepKey: goToBillingInformationUseDefaultShippingMethod
		$I->comment("Exiting Action Group [useDefaultShippingMethod] StorefrontLeaveDefaultShippingMethodsAndGoToBillingInfoActionGroup");
		$I->comment("Click 'Go to Review Your Order'");
		$I->comment("Entering Action Group [useDefaultBillingMethod] SelectBillingInfoActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForBillingInfoPageLoadUseDefaultBillingMethod
		$I->click("#payment-continue"); // stepKey: goToReviewOrderUseDefaultBillingMethod
		$I->waitForPageLoad(30); // stepKey: goToReviewOrderUseDefaultBillingMethodWaitForPageLoad
		$I->comment("Exiting Action Group [useDefaultBillingMethod] SelectBillingInfoActionGroup");
		$I->comment("Click 'Place Order'");
		$I->comment("Entering Action Group [placeOrder] PlaceOrderActionGroup");
		$I->click("#review-button"); // stepKey: checkoutMultiShipmentPlaceOrderPlaceOrder
		$I->waitForPageLoad(30); // stepKey: waitForSuccessfullyPlacedOrderPlaceOrder
		$I->see("Thank you for your purchase!", ".page-title"); // stepKey: waitForLoadSuccessPagePlaceOrder
		$I->comment("Exiting Action Group [placeOrder] PlaceOrderActionGroup");
		$I->comment("Open the first product page");
		$I->comment("Entering Action Group [goToFirstProductPageSecondTime] StorefrontOpenProductPageActionGroup");
		$I->amOnPage("/" . $I->retrieveEntityField('firstProduct', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: openProductPageGoToFirstProductPageSecondTime
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoadedGoToFirstProductPageSecondTime
		$I->comment("Exiting Action Group [goToFirstProductPageSecondTime] StorefrontOpenProductPageActionGroup");
		$I->comment("Add three identical products to the Shopping Cart");
		$I->comment("Entering Action Group [addIdenticalProductsToCart] AddProductWithQtyToCartFromStorefrontProductPageActionGroup");
		$I->fillField("#qty", "3"); // stepKey: fillProductQuantityAddIdenticalProductsToCart
		$I->click("#product-addtocart-button"); // stepKey: addToCartAddIdenticalProductsToCart
		$I->waitForPageLoad(60); // stepKey: addToCartAddIdenticalProductsToCartWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForAddToCartAddIdenticalProductsToCart
		$I->waitForElementNotVisible("//button/span[text()='Adding...']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddingAddIdenticalProductsToCart
		$I->waitForElementNotVisible("//button/span[text()='Added']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddedAddIdenticalProductsToCart
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAddIdenticalProductsToCart
		$I->waitForElementVisible("div.message-success.success.message", 30); // stepKey: waitForSuccessMessageAddIdenticalProductsToCart
		$I->see("You added " . $I->retrieveEntityField('firstProduct', 'name', 'test') . " to your shopping cart.", "div.message-success.success.message"); // stepKey: seeAddToCartSuccessMessageAddIdenticalProductsToCart
		$I->comment("Exiting Action Group [addIdenticalProductsToCart] AddProductWithQtyToCartFromStorefrontProductPageActionGroup");
		$I->comment("Go to Cart");
		$I->comment("Entering Action Group [openCartWithIdenticalProducts] StorefrontOpenCartFromMinicartActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollToTopOfThePageOpenCartWithIdenticalProducts
		$I->waitForElement("a.showcart", 30); // stepKey: waitForShowMinicartOpenCartWithIdenticalProducts
		$I->waitForPageLoad(60); // stepKey: waitForShowMinicartOpenCartWithIdenticalProductsWaitForPageLoad
		$I->waitForElement(".action.viewcart", 30); // stepKey: waitForCartLinkOpenCartWithIdenticalProducts
		$I->waitForPageLoad(30); // stepKey: waitForCartLinkOpenCartWithIdenticalProductsWaitForPageLoad
		$I->click("a.showcart"); // stepKey: clickShowMinicartOpenCartWithIdenticalProducts
		$I->waitForPageLoad(60); // stepKey: clickShowMinicartOpenCartWithIdenticalProductsWaitForPageLoad
		$I->click(".action.viewcart"); // stepKey: clickCartOpenCartWithIdenticalProducts
		$I->waitForPageLoad(30); // stepKey: clickCartOpenCartWithIdenticalProductsWaitForPageLoad
		$I->comment("Exiting Action Group [openCartWithIdenticalProducts] StorefrontOpenCartFromMinicartActionGroup");
		$I->comment("Check Out with Multiple Addresses");
		$I->comment("Entering Action Group [checkoutWithThreeDifferentAddresses] StorefrontCheckoutWithMultipleAddressesActionGroup");
		$I->click("//span[text()='Check Out with Multiple Addresses']"); // stepKey: clickOnCheckoutWithMultipleAddressesCheckoutWithThreeDifferentAddresses
		$I->waitForPageLoad(30); // stepKey: waitForMultipleAddressPageLoadCheckoutWithThreeDifferentAddresses
		$I->comment("Exiting Action Group [checkoutWithThreeDifferentAddresses] StorefrontCheckoutWithMultipleAddressesActionGroup");
		$I->comment("Select different addresses and click 'Go to Shipping Information'");
		$I->comment("Entering Action Group [selectFirstAddressFromThree] StorefrontSelectAddressActionGroup");
		$I->selectOption("(//table[@id='multiship-addresses-table'] //div[@class='field address'] //select)[1]", "John Doe, 368 Broadway St. 113, New York, New York 10001, United States"); // stepKey: selectShippingAddressSelectFirstAddressFromThree
		$I->comment("Exiting Action Group [selectFirstAddressFromThree] StorefrontSelectAddressActionGroup");
		$I->comment("Entering Action Group [selectSecondAddressFromThree] StorefrontSelectAddressActionGroup");
		$I->selectOption("(//table[@id='multiship-addresses-table'] //div[@class='field address'] //select)[2]", "John Doe, Augsburger Strabe 41, Berlin,  10789, Germany"); // stepKey: selectShippingAddressSelectSecondAddressFromThree
		$I->comment("Exiting Action Group [selectSecondAddressFromThree] StorefrontSelectAddressActionGroup");
		$I->comment("Entering Action Group [selectThirdAddressFromThree] StorefrontSelectAddressActionGroup");
		$I->selectOption("(//table[@id='multiship-addresses-table'] //div[@class='field address'] //select)[3]", "Jane Doe, 172, Westminster Bridge Rd, London,  SE1 7RW, United Kingdom"); // stepKey: selectShippingAddressSelectThirdAddressFromThree
		$I->comment("Exiting Action Group [selectThirdAddressFromThree] StorefrontSelectAddressActionGroup");
		$I->comment("Entering Action Group [saveThreeDifferentAddresses] StorefrontSaveAddressActionGroup");
		$I->click("//button[@class='action update']"); // stepKey: clickOnUpdateAddressSaveThreeDifferentAddresses
		$I->waitForPageLoad(90); // stepKey: waitForShippingInformationAfterUpdatedSaveThreeDifferentAddresses
		$I->click("//span[text()='Go to Shipping Information']"); // stepKey: goToShippingInformationSaveThreeDifferentAddresses
		$I->waitForPageLoad(30); // stepKey: waitForShippingPageLoadSaveThreeDifferentAddresses
		$I->comment("Exiting Action Group [saveThreeDifferentAddresses] StorefrontSaveAddressActionGroup");
		$I->comment("Click 'Continue to Billing Information'");
		$I->comment("Entering Action Group [useDefaultShippingMethodForIdenticalProducts] StorefrontLeaveDefaultShippingMethodsAndGoToBillingInfoActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForShippingInfoUseDefaultShippingMethodForIdenticalProducts
		$I->click(".action.primary.continue"); // stepKey: goToBillingInformationUseDefaultShippingMethodForIdenticalProducts
		$I->comment("Exiting Action Group [useDefaultShippingMethodForIdenticalProducts] StorefrontLeaveDefaultShippingMethodsAndGoToBillingInfoActionGroup");
		$I->comment("Click 'Go to Review Your Order'");
		$I->comment("Entering Action Group [UseDefaultBillingMethodForIdenticalProducts] SelectBillingInfoActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForBillingInfoPageLoadUseDefaultBillingMethodForIdenticalProducts
		$I->click("#payment-continue"); // stepKey: goToReviewOrderUseDefaultBillingMethodForIdenticalProducts
		$I->waitForPageLoad(30); // stepKey: goToReviewOrderUseDefaultBillingMethodForIdenticalProductsWaitForPageLoad
		$I->comment("Exiting Action Group [UseDefaultBillingMethodForIdenticalProducts] SelectBillingInfoActionGroup");
		$I->comment("Click 'Place Order'");
		$I->comment("Entering Action Group [placeOrderWithIdenticalProducts] PlaceOrderActionGroup");
		$I->click("#review-button"); // stepKey: checkoutMultiShipmentPlaceOrderPlaceOrderWithIdenticalProducts
		$I->waitForPageLoad(30); // stepKey: waitForSuccessfullyPlacedOrderPlaceOrderWithIdenticalProducts
		$I->see("Thank you for your purchase!", ".page-title"); // stepKey: waitForLoadSuccessPagePlaceOrderWithIdenticalProducts
		$I->comment("Exiting Action Group [placeOrderWithIdenticalProducts] PlaceOrderActionGroup");
	}
}
