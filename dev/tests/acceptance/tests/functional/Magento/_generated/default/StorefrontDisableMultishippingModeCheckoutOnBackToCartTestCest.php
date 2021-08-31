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
 * @Title("MC-39007: Disable multishipping checkout on backing to cart")
 * @Description("Cart page summary block should count virtual product price after backing back to the cart from multishipping checkout.<h3>Test files</h3>app/code/Magento/Multishipping/Test/Mftf/Test/StorefrontDisableMultishippingModeCheckoutOnBackToCartTest.xml<br>")
 * @TestCaseId("MC-39007")
 * @group multishipping
 */
class StorefrontDisableMultishippingModeCheckoutOnBackToCartTestCest
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
		$I->createEntity("createCategory", "hook", "ApiCategory", [], []); // stepKey: createCategory
		$I->createEntity("createSimpleProduct", "hook", "_defaultProduct", ["createCategory"], []); // stepKey: createSimpleProduct
		$I->createEntity("createVirtualProduct", "hook", "VirtualProduct", ["createCategory"], []); // stepKey: createVirtualProduct
		$I->createEntity("createCustomerWithMultipleAddresses", "hook", "Simple_US_Customer_Multiple_Addresses", [], []); // stepKey: createCustomerWithMultipleAddresses
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->deleteEntity("createSimpleProduct", "hook"); // stepKey: deleteSimpleProduct
		$I->deleteEntity("createVirtualProduct", "hook"); // stepKey: deleteVirtualProduct
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
	 * @Stories({"Multishipping"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function StorefrontDisableMultishippingModeCheckoutOnBackToCartTest(AcceptanceTester $I)
	{
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
		$I->comment("Entering Action Group [openVirtualProductPage] StorefrontOpenProductEntityPageActionGroup");
		$I->amOnPage("/" . $I->retrieveEntityField('createVirtualProduct', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: goToProductPageOpenVirtualProductPage
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoadedOpenVirtualProductPage
		$I->comment("Exiting Action Group [openVirtualProductPage] StorefrontOpenProductEntityPageActionGroup");
		$I->comment("Entering Action Group [addVirtualProductToCart] StorefrontAddProductToCartActionGroup");
		$I->click("button#product-addtocart-button"); // stepKey: clickAddToCartAddVirtualProductToCart
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAddVirtualProductToCart
		$I->waitForElementVisible("div.message-success", 30); // stepKey: waitForSuccessMessageAddVirtualProductToCart
		$I->see("You added " . $I->retrieveEntityField('createVirtualProduct', 'name', 'test') . " to your shopping cart.", ".page.messages"); // stepKey: assertSuccessMessageAddVirtualProductToCart
		$I->waitForPageLoad(30); // stepKey: assertSuccessMessageAddVirtualProductToCartWaitForPageLoad
		$I->seeLink("shopping cart", getenv("MAGENTO_BASE_URL") . "checkout/cart/"); // stepKey: assertLinkToShoppingCartAddVirtualProductToCart
		$I->waitForText("1", 30, "//header//div[contains(@class, 'minicart-wrapper')]//a[contains(@class, 'showcart')]//span[@class='counter-number']"); // stepKey: assertProductCountAddVirtualProductToCart
		$I->comment("Exiting Action Group [addVirtualProductToCart] StorefrontAddProductToCartActionGroup");
		$I->comment("Entering Action Group [openSimpleProductPage] StorefrontOpenProductEntityPageActionGroup");
		$I->amOnPage("/" . $I->retrieveEntityField('createSimpleProduct', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: goToProductPageOpenSimpleProductPage
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoadedOpenSimpleProductPage
		$I->comment("Exiting Action Group [openSimpleProductPage] StorefrontOpenProductEntityPageActionGroup");
		$I->comment("Entering Action Group [addSimpleProductToCart] StorefrontAddProductToCartActionGroup");
		$I->click("button#product-addtocart-button"); // stepKey: clickAddToCartAddSimpleProductToCart
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAddSimpleProductToCart
		$I->waitForElementVisible("div.message-success", 30); // stepKey: waitForSuccessMessageAddSimpleProductToCart
		$I->see("You added " . $I->retrieveEntityField('createSimpleProduct', 'name', 'test') . " to your shopping cart.", ".page.messages"); // stepKey: assertSuccessMessageAddSimpleProductToCart
		$I->waitForPageLoad(30); // stepKey: assertSuccessMessageAddSimpleProductToCartWaitForPageLoad
		$I->seeLink("shopping cart", getenv("MAGENTO_BASE_URL") . "checkout/cart/"); // stepKey: assertLinkToShoppingCartAddSimpleProductToCart
		$I->waitForText("2", 30, "//header//div[contains(@class, 'minicart-wrapper')]//a[contains(@class, 'showcart')]//span[@class='counter-number']"); // stepKey: assertProductCountAddSimpleProductToCart
		$I->comment("Exiting Action Group [addSimpleProductToCart] StorefrontAddProductToCartActionGroup");
		$I->comment("Entering Action Group [goToShoppingCartFromMinicart] ClickViewAndEditCartFromMiniCartActionGroup");
		$I->scrollTo("a.showcart"); // stepKey: scrollToMiniCartGoToShoppingCartFromMinicart
		$I->waitForPageLoad(60); // stepKey: scrollToMiniCartGoToShoppingCartFromMinicartWaitForPageLoad
		$I->conditionalClick("a.showcart", "a.showcart.active", false); // stepKey: openMiniCartGoToShoppingCartFromMinicart
		$I->waitForElementVisible(".action.viewcart", 30); // stepKey: waitForViewAndEditCartVisibleGoToShoppingCartFromMinicart
		$I->waitForPageLoad(30); // stepKey: waitForViewAndEditCartVisibleGoToShoppingCartFromMinicartWaitForPageLoad
		$I->click(".action.viewcart"); // stepKey: viewAndEditCartGoToShoppingCartFromMinicart
		$I->waitForPageLoad(30); // stepKey: viewAndEditCartGoToShoppingCartFromMinicartWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadGoToShoppingCartFromMinicart
		$I->seeInCurrentUrl("checkout/cart"); // stepKey: seeInCurrentUrlGoToShoppingCartFromMinicart
		$I->comment("Exiting Action Group [goToShoppingCartFromMinicart] ClickViewAndEditCartFromMiniCartActionGroup");
		$grabTotal = $I->grabTextFrom("//tr[@class='grand totals']//span[@class='price']"); // stepKey: grabTotal
		$I->comment("Entering Action Group [goCheckoutWithMultipleAddresses] StorefrontGoCheckoutWithMultipleAddressesActionGroup");
		$I->waitForAjaxLoad(30); // stepKey: waitAjaxLoadGoCheckoutWithMultipleAddresses
		$I->click(".action.multicheckout"); // stepKey: clickToMultipleAddressShippingButtonGoCheckoutWithMultipleAddresses
		$I->waitForPageLoad(30); // stepKey: waitForMultipleCheckoutLoadGoCheckoutWithMultipleAddresses
		$I->seeElement("//span[text()='Ship to Multiple Addresses']"); // stepKey: seeMultipleCheckoutPageTitleGoCheckoutWithMultipleAddresses
		$I->comment("Exiting Action Group [goCheckoutWithMultipleAddresses] StorefrontGoCheckoutWithMultipleAddressesActionGroup");
		$I->comment("Entering Action Group [goBackToShoppingCartPage] StorefrontCartPageOpenActionGroup");
		$I->amOnPage("/checkout/cart"); // stepKey: openCartPageGoBackToShoppingCartPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadedGoBackToShoppingCartPage
		$I->comment("Exiting Action Group [goBackToShoppingCartPage] StorefrontCartPageOpenActionGroup");
		$I->comment("Entering Action Group [assertSummaryTotal] AssertStorefrontCheckoutPaymentSummaryTotalActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForCartFullyLoadedAssertSummaryTotal
		$I->waitForElementVisible("//tr[@class='grand totals']//span[@class='price']", 30); // stepKey: waitForOrderSummaryBlockAssertSummaryTotal
		$I->see($grabTotal, "//tr[@class='grand totals']//span[@class='price']"); // stepKey: seeCorrectOrderTotalAssertSummaryTotal
		$I->comment("Exiting Action Group [assertSummaryTotal] AssertStorefrontCheckoutPaymentSummaryTotalActionGroup");
	}
}
