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
 * @Title("MAGETWO-46795: Estimator in Shopping cart must be pre-filled by Customer default shipping address for virtual quote")
 * @Description("Estimator in Shopping cart must be pre-filled by Customer default shipping address for virtual quote<h3>Test files</h3>app/code/Magento/Checkout/Test/Mftf/Test/StorefrontShoppingCartCheckCustomerDefaultShippingAddressForVirtualQuoteTest.xml<br>")
 * @TestCaseId("MAGETWO-46795")
 * @group checkout
 */
class StorefrontShoppingCartCheckCustomerDefaultShippingAddressForVirtualQuoteTestCest
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
		$I->createEntity("createVirtualProduct", "hook", "VirtualProduct", [], []); // stepKey: createVirtualProduct
		$I->createEntity("createCustomer", "hook", "Customer_With_Different_Default_Billing_Shipping_Addresses", [], []); // stepKey: createCustomer
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [customerLogout] StorefrontCustomerLogoutActionGroup");
		$I->amOnPage("customer/account/logout/"); // stepKey: storefrontSignOutCustomerLogout
		$I->waitForPageLoad(30); // stepKey: waitForSignOutCustomerLogout
		$I->comment("Exiting Action Group [customerLogout] StorefrontCustomerLogoutActionGroup");
		$I->deleteEntity("createVirtualProduct", "hook"); // stepKey: deleteVirtualProduct
		$I->deleteEntity("createCustomer", "hook"); // stepKey: deleteCustomer
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
	 * @Stories({"Estimator in Shopping cart must be pre-filled by Customer default shipping address for virtual quote"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function StorefrontShoppingCartCheckCustomerDefaultShippingAddressForVirtualQuoteTest(AcceptanceTester $I)
	{
		$I->comment("Steps");
		$I->comment("Step 1: Go to Storefront as Customer");
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
		$I->comment("Step 2: Add virtual product to cart");
		$I->amOnPage("/" . $I->retrieveEntityField('createVirtualProduct', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: amOnPage
		$I->comment("Entering Action Group [addProductToCart] StorefrontAddProductToCartActionGroup");
		$I->click("button#product-addtocart-button"); // stepKey: clickAddToCartAddProductToCart
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAddProductToCart
		$I->waitForElementVisible("div.message-success", 30); // stepKey: waitForSuccessMessageAddProductToCart
		$I->see("You added " . $I->retrieveEntityField('createVirtualProduct', 'name', 'test') . " to your shopping cart.", ".page.messages"); // stepKey: assertSuccessMessageAddProductToCart
		$I->waitForPageLoad(30); // stepKey: assertSuccessMessageAddProductToCartWaitForPageLoad
		$I->seeLink("shopping cart", getenv("MAGENTO_BASE_URL") . "checkout/cart/"); // stepKey: assertLinkToShoppingCartAddProductToCart
		$I->waitForText("1", 30, "//header//div[contains(@class, 'minicart-wrapper')]//a[contains(@class, 'showcart')]//span[@class='counter-number']"); // stepKey: assertProductCountAddProductToCart
		$I->comment("Exiting Action Group [addProductToCart] StorefrontAddProductToCartActionGroup");
		$I->comment("Step 3: Go to Shopping Cart");
		$I->comment("Entering Action Group [goToShoppingcart] ClickViewAndEditCartFromMiniCartActionGroup");
		$I->scrollTo("a.showcart"); // stepKey: scrollToMiniCartGoToShoppingcart
		$I->waitForPageLoad(60); // stepKey: scrollToMiniCartGoToShoppingcartWaitForPageLoad
		$I->conditionalClick("a.showcart", "a.showcart.active", false); // stepKey: openMiniCartGoToShoppingcart
		$I->waitForElementVisible(".action.viewcart", 30); // stepKey: waitForViewAndEditCartVisibleGoToShoppingcart
		$I->waitForPageLoad(30); // stepKey: waitForViewAndEditCartVisibleGoToShoppingcartWaitForPageLoad
		$I->click(".action.viewcart"); // stepKey: viewAndEditCartGoToShoppingcart
		$I->waitForPageLoad(30); // stepKey: viewAndEditCartGoToShoppingcartWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadGoToShoppingcart
		$I->seeInCurrentUrl("checkout/cart"); // stepKey: seeInCurrentUrlGoToShoppingcart
		$I->comment("Exiting Action Group [goToShoppingcart] ClickViewAndEditCartFromMiniCartActionGroup");
		$I->comment("Step 4: Open Estimate Tax section");
		$I->click("#block-shipping-heading"); // stepKey: openEstimateTaxSection
		$I->waitForPageLoad(5); // stepKey: openEstimateTaxSectionWaitForPageLoad
		$I->seeOptionIsSelected("select[name='country_id']", "United States"); // stepKey: checkCountry
		$I->waitForPageLoad(10); // stepKey: checkCountryWaitForPageLoad
		$I->seeOptionIsSelected("select[name='region_id']", "California"); // stepKey: checkState
		$I->waitForPageLoad(10); // stepKey: checkStateWaitForPageLoad
		$I->scrollTo("input[name='postcode']"); // stepKey: scrollToPostCodeField
		$I->waitForPageLoad(10); // stepKey: scrollToPostCodeFieldWaitForPageLoad
		$grabTextPostCode = $I->grabValueFrom("input[name='postcode']"); // stepKey: grabTextPostCode
		$I->waitForPageLoad(10); // stepKey: grabTextPostCodeWaitForPageLoad
		$I->assertEquals("90001", $grabTextPostCode, "Customer postcode is invalid"); // stepKey: checkCustomerPostcode
	}
}
