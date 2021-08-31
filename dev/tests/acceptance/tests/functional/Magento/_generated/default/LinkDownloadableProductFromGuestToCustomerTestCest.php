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
 * @Title("MC-16011: Customer should see downloadable products after place order as guest and registering after that")
 * @Description("Verify that in 'My Downloadable Products' section in customer account user can see products.<h3>Test files</h3>app/code/Magento/Downloadable/Test/Mftf/Test/LinkDownloadableProductFromGuestToCustomerTest.xml<br>")
 * @TestCaseId("MC-16011")
 */
class LinkDownloadableProductFromGuestToCustomerTestCest
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
		$addDownloadableDomain = $I->magentoCLI("downloadable:domains:add example.com static.magento.com", 60); // stepKey: addDownloadableDomain
		$I->comment($addDownloadableDomain);
		$enableGuestCheckoutWithDownloadableItems = $I->magentoCLI("config:set catalog/downloadable/disable_guest_checkout 0", 60); // stepKey: enableGuestCheckoutWithDownloadableItems
		$I->comment($enableGuestCheckoutWithDownloadableItems);
		$enableShareableDownloadableItems = $I->magentoCLI("config:set catalog/downloadable/shareable 1", 60); // stepKey: enableShareableDownloadableItems
		$I->comment($enableShareableDownloadableItems);
		$I->createEntity("createCategory", "hook", "_defaultCategory", [], []); // stepKey: createCategory
		$I->createEntity("createProduct", "hook", "DownloadableProductWithOneLink", ["createCategory"], []); // stepKey: createProduct
		$I->createEntity("addDownloadableLink", "hook", "downloadableLinkSharable", ["createProduct"], []); // stepKey: addDownloadableLink
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$removeDownloadableDomain = $I->magentoCLI("downloadable:domains:remove example.com static.magento.com", 60); // stepKey: removeDownloadableDomain
		$I->comment($removeDownloadableDomain);
		$disableGuestCheckoutWithDownloadableItems = $I->magentoCLI("config:set catalog/downloadable/disable_guest_checkout 1", 60); // stepKey: disableGuestCheckoutWithDownloadableItems
		$I->comment($disableGuestCheckoutWithDownloadableItems);
		$I->deleteEntity("createProduct", "hook"); // stepKey: deleteProduct
		$I->deleteEntity("createCategory", "hook"); // stepKey: deleteCategory
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
	 * @Stories({"Customer Account"})
	 * @Severity(level = SeverityLevel::MINOR)
	 * @Features({"Downloadable"})
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function LinkDownloadableProductFromGuestToCustomerTest(AcceptanceTester $I)
	{
		$I->comment("Step 1: Go to Storefront as Guest");
		$I->comment("Entering Action Group [amOnStorefrontPage] StorefrontOpenHomePageActionGroup");
		$I->amOnPage("/"); // stepKey: goToStorefrontPageAmOnStorefrontPage
		$I->waitForPageLoad(30); // stepKey: waitForStorefrontPageLoadAmOnStorefrontPage
		$I->comment("Exiting Action Group [amOnStorefrontPage] StorefrontOpenHomePageActionGroup");
		$I->comment("Step 2: Add downloadable product to shopping cart");
		$I->amOnPage("/" . $I->retrieveEntityField('createProduct', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: amOnStorefrontProductPage
		$I->comment("Entering Action Group [addProductToCart] StorefrontAddProductToCartActionGroup");
		$I->click("button#product-addtocart-button"); // stepKey: clickAddToCartAddProductToCart
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAddProductToCart
		$I->waitForElementVisible("div.message-success", 30); // stepKey: waitForSuccessMessageAddProductToCart
		$I->see("You added " . $I->retrieveEntityField('createProduct', 'name', 'test') . " to your shopping cart.", ".page.messages"); // stepKey: assertSuccessMessageAddProductToCart
		$I->waitForPageLoad(30); // stepKey: assertSuccessMessageAddProductToCartWaitForPageLoad
		$I->seeLink("shopping cart", getenv("MAGENTO_BASE_URL") . "checkout/cart/"); // stepKey: assertLinkToShoppingCartAddProductToCart
		$I->waitForText("1", 30, "//header//div[contains(@class, 'minicart-wrapper')]//a[contains(@class, 'showcart')]//span[@class='counter-number']"); // stepKey: assertProductCountAddProductToCart
		$I->comment("Exiting Action Group [addProductToCart] StorefrontAddProductToCartActionGroup");
		$I->comment("Step 3: Go to checkout");
		$I->comment("Entering Action Group [goToCheckoutFromMinicart] GoToCheckoutFromMinicartActionGroup");
		$I->waitForElementNotVisible(".counter.qty.empty", 30); // stepKey: waitUpdateQuantityGoToCheckoutFromMinicart
		$I->wait(5); // stepKey: waitMinicartRenderingGoToCheckoutFromMinicart
		$I->click("a.showcart"); // stepKey: clickCartGoToCheckoutFromMinicart
		$I->waitForPageLoad(60); // stepKey: clickCartGoToCheckoutFromMinicartWaitForPageLoad
		$I->click("#top-cart-btn-checkout"); // stepKey: goToCheckoutGoToCheckoutFromMinicart
		$I->waitForPageLoad(30); // stepKey: goToCheckoutGoToCheckoutFromMinicartWaitForPageLoad
		$I->comment("Exiting Action Group [goToCheckoutFromMinicart] GoToCheckoutFromMinicartActionGroup");
		$I->comment("Step 4: Select Check/Money Order payment, fill required fields and click Update and Place Order");
		$I->comment("Entering Action Group [selectCheckMoneyOrderPayment] CheckoutSelectCheckMoneyOrderPaymentActionGroup");
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskSelectCheckMoneyOrderPayment
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadSelectCheckMoneyOrderPayment
		$I->conditionalClick("//div[@id='checkout-payment-method-load']//div[@class='payment-method']//label//span[contains(., 'Check / Money order')]/../..//input", "//div[@id='checkout-payment-method-load']//div[@class='payment-method']//label//span[contains(., 'Check / Money order')]/../..//input", true); // stepKey: selectCheckmoPaymentMethodSelectCheckMoneyOrderPayment
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskAfterPaymentMethodSelectionSelectCheckMoneyOrderPayment
		$I->comment("Exiting Action Group [selectCheckMoneyOrderPayment] CheckoutSelectCheckMoneyOrderPaymentActionGroup");
		$I->comment("Entering Action Group [changeAddress] GuestCheckoutSelectPaymentAndFillNewBillingAddressActionGroup");
		$I->fillField("input[id*=customer-email]", msq("Simple_US_Customer_NY") . "John.Doe@example.com"); // stepKey: enterEmailChangeAddress
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoading3ChangeAddress
		$I->waitForElement("//*[@id='checkout-payment-method-load']//div[@data-role='title']", 30); // stepKey: waitForPaymentSectionLoadedChangeAddress
		$I->conditionalClick("//*[@id='checkout-payment-method-load']//*[contains(@class, 'payment-group')]//label[normalize-space(.)='Check / Money order']", ".payment-method._active div.billing-address-details", false); // stepKey: clickCheckMoneyOrderPaymentChangeAddress
		$I->fillField(".payment-method._active .billing-address-form input[name='firstname']", "John"); // stepKey: enterFirstNameChangeAddress
		$I->fillField(".payment-method._active .billing-address-form input[name*='lastname']", "Doe"); // stepKey: enterLastNameChangeAddress
		$I->fillField(".payment-method._active .billing-address-form input[name*='street[0]']", "368 Broadway St."); // stepKey: enterStreetChangeAddress
		$I->fillField(".payment-method._active .billing-address-form input[name*='city']", "New York"); // stepKey: enterCityChangeAddress
		$I->selectOption(".payment-method._active .billing-address-form select[name*='region_id']", "New York"); // stepKey: selectRegionChangeAddress
		$I->fillField(".payment-method._active .billing-address-form input[name*='postcode']", "10001"); // stepKey: enterPostcodeChangeAddress
		$I->fillField(".payment-method._active .billing-address-form input[name*='telephone']", "512-345-6789"); // stepKey: enterTelephoneChangeAddress
		$I->comment("Exiting Action Group [changeAddress] GuestCheckoutSelectPaymentAndFillNewBillingAddressActionGroup");
		$I->click(".action-update"); // stepKey: saveAddress
		$I->waitForPageLoad(30); // stepKey: waitUpdateAddress
		$I->comment("Entering Action Group [placeOrder] CheckoutPlaceOrderActionGroup");
		$I->waitForElementVisible(".payment-method._active button.action.primary.checkout", 30); // stepKey: waitForPlaceOrderButtonPlaceOrder
		$I->waitForPageLoad(30); // stepKey: waitForPlaceOrderButtonPlaceOrderWaitForPageLoad
		$I->click(".payment-method._active button.action.primary.checkout"); // stepKey: clickPlaceOrderPlaceOrder
		$I->waitForPageLoad(30); // stepKey: clickPlaceOrderPlaceOrderWaitForPageLoad
		$I->see("Your order # is:", "div.checkout-success"); // stepKey: seeOrderNumberPlaceOrder
		$I->see("We'll email you an order confirmation with details and tracking info.", "div.checkout-success"); // stepKey: seeEmailYouPlaceOrder
		$I->comment("Exiting Action Group [placeOrder] CheckoutPlaceOrderActionGroup");
		$I->comment("Step 5: Create customer account after placing order");
		$I->comment("Entering Action Group [createCustomerAfterPlaceOrder] StorefrontRegisterCustomerFromOrderSuccessPage");
		$I->click("[data-bind*=\"i18n: 'Create an Account'\"]"); // stepKey: clickCreateAccountButtonCreateCustomerAfterPlaceOrder
		$I->waitForPageLoad(30); // stepKey: clickCreateAccountButtonCreateCustomerAfterPlaceOrderWaitForPageLoad
		$I->fillField("#password", "pwdTest123!"); // stepKey: typePasswordCreateCustomerAfterPlaceOrder
		$I->fillField("#password-confirmation", "pwdTest123!"); // stepKey: typeConfirmationPasswordCreateCustomerAfterPlaceOrder
		$I->click("button.action.submit.primary"); // stepKey: clickOnCreateAccountCreateCustomerAfterPlaceOrder
		$I->waitForPageLoad(30); // stepKey: clickOnCreateAccountCreateCustomerAfterPlaceOrderWaitForPageLoad
		$I->see("Thank you for registering", "div.message-success.success.message"); // stepKey: verifyAccountCreatedCreateCustomerAfterPlaceOrder
		$I->comment("Exiting Action Group [createCustomerAfterPlaceOrder] StorefrontRegisterCustomerFromOrderSuccessPage");
		$I->comment("Step 6: Go To My Account -> My Downloadable Products and check if downloadable product link exist");
		$I->comment("Entering Action Group [seeStorefontMyDownloadableProductsProductName] StorefrontAssertDownloadableProductIsPresentInCustomerAccount");
		$I->amOnPage("/customer/account/"); // stepKey: goToMyAccountPageSeeStorefontMyDownloadableProductsProductName
		$I->click("//div[@id='block-collapsible-nav']//a[text()='My Downloadable Products']"); // stepKey: clickDownloadableProductsSeeStorefontMyDownloadableProductsProductName
		$I->waitForPageLoad(60); // stepKey: clickDownloadableProductsSeeStorefontMyDownloadableProductsProductNameWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForDownloadableProductsPageLoadSeeStorefontMyDownloadableProductsProductName
		$I->seeElement("//table[@id='my-downloadable-products-table']//strong[contains(@class, 'product-name') and normalize-space(.)='" . $I->retrieveEntityField('createProduct', 'name', 'test') . "']"); // stepKey: seeStorefontDownloadableProductsProductNameSeeStorefontMyDownloadableProductsProductName
		$I->comment("Exiting Action Group [seeStorefontMyDownloadableProductsProductName] StorefrontAssertDownloadableProductIsPresentInCustomerAccount");
	}
}
