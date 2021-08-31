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
 * @Title("MC-34465: Make reorder as guest on Frontend")
 * @Description("Make reorder as guest on Frontend<h3>Test files</h3>app/code/Magento/Sales/Test/Mftf/Test/StorefrontReorderAsGuestTest.xml<br>")
 * @TestCaseId("MC-34465")
 * @group sales
 */
class StorefrontReorderAsGuestTestCest
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
		$I->comment("Create simple product.");
		$I->createEntity("createCategory", "hook", "SimpleSubCategory", [], []); // stepKey: createCategory
		$I->createEntity("createSimpleProduct", "hook", "SimpleProduct", ["createCategory"], []); // stepKey: createSimpleProduct
		$I->comment("Create Customer Account");
		$I->createEntity("createCustomer", "hook", "Simple_US_Customer", [], []); // stepKey: createCustomer
		$I->comment("Adding the comment to replace 'indexer:reindex' command for preserving Backward Compatibility");
		$I->comment("Adding the comment to replace 'cache:flush' command for preserving Backward Compatibility");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->deleteEntity("createCustomer", "hook"); // stepKey: deleteCreateCustomer
		$I->deleteEntity("createSimpleProduct", "hook"); // stepKey: deleteSimpleProduct
		$I->deleteEntity("createCategory", "hook"); // stepKey: deleteCategory
		$I->comment("Reindex invalidated indices after product attribute has been created/deleted");
		$reindexInvalidatedIndices = $I->magentoCron("index", 90); // stepKey: reindexInvalidatedIndices
		$I->comment($reindexInvalidatedIndices);
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
	 * @Stories({"Reorder"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Features({"Sales"})
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function StorefrontReorderAsGuestTest(AcceptanceTester $I)
	{
		$I->comment("Order a product");
		$I->amOnPage("/" . $I->retrieveEntityField('createSimpleProduct', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: navigateToPDP
		$I->comment("Entering Action Group [cartAddSimpleProductToCart] StorefrontAddProductToCartActionGroup");
		$I->click("button#product-addtocart-button"); // stepKey: clickAddToCartCartAddSimpleProductToCart
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadCartAddSimpleProductToCart
		$I->waitForElementVisible("div.message-success", 30); // stepKey: waitForSuccessMessageCartAddSimpleProductToCart
		$I->see("You added " . $I->retrieveEntityField('createSimpleProduct', 'name', 'test') . " to your shopping cart.", ".page.messages"); // stepKey: assertSuccessMessageCartAddSimpleProductToCart
		$I->waitForPageLoad(30); // stepKey: assertSuccessMessageCartAddSimpleProductToCartWaitForPageLoad
		$I->seeLink("shopping cart", getenv("MAGENTO_BASE_URL") . "checkout/cart/"); // stepKey: assertLinkToShoppingCartCartAddSimpleProductToCart
		$I->waitForText("1", 30, "//header//div[contains(@class, 'minicart-wrapper')]//a[contains(@class, 'showcart')]//span[@class='counter-number']"); // stepKey: assertProductCountCartAddSimpleProductToCart
		$I->comment("Exiting Action Group [cartAddSimpleProductToCart] StorefrontAddProductToCartActionGroup");
		$I->comment("Entering Action Group [navigateToCheckout] GoToCheckoutFromMinicartActionGroup");
		$I->waitForElementNotVisible(".counter.qty.empty", 30); // stepKey: waitUpdateQuantityNavigateToCheckout
		$I->wait(5); // stepKey: waitMinicartRenderingNavigateToCheckout
		$I->click("a.showcart"); // stepKey: clickCartNavigateToCheckout
		$I->waitForPageLoad(60); // stepKey: clickCartNavigateToCheckoutWaitForPageLoad
		$I->click("#top-cart-btn-checkout"); // stepKey: goToCheckoutNavigateToCheckout
		$I->waitForPageLoad(30); // stepKey: goToCheckoutNavigateToCheckoutWaitForPageLoad
		$I->comment("Exiting Action Group [navigateToCheckout] GoToCheckoutFromMinicartActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitFroPaymentSelectionPageLoad
		$I->comment("Entering Action Group [fillAddress] GuestCheckoutFillingShippingSectionActionGroup");
		$I->waitForElementVisible("input[id*=customer-email]", 30); // stepKey: waitForEmailFieldFillAddress
		$I->fillField("input[id*=customer-email]", $I->retrieveEntityField('createCustomer', 'email', 'test')); // stepKey: enterEmailFillAddress
		$I->fillField("input[name=firstname]", $I->retrieveEntityField('createCustomer', 'firstname', 'test')); // stepKey: enterFirstNameFillAddress
		$I->fillField("input[name=lastname]", $I->retrieveEntityField('createCustomer', 'lastname', 'test')); // stepKey: enterLastNameFillAddress
		$I->fillField("input[name='street[0]']", "7700 West Parmer Lane"); // stepKey: enterStreetFillAddress
		$I->fillField("input[name=city]", "Austin"); // stepKey: enterCityFillAddress
		$I->selectOption("select[name=region_id]", "Texas"); // stepKey: selectRegionFillAddress
		$I->fillField("input[name=postcode]", "78729"); // stepKey: enterPostcodeFillAddress
		$I->fillField("input[name=telephone]", "512-345-6789"); // stepKey: enterTelephoneFillAddress
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskFillAddress
		$I->waitForElement("//div[@id='checkout-shipping-method-load']//td[contains(., '')]/..//input", 30); // stepKey: waitForShippingMethodFillAddress
		$I->click("//div[@id='checkout-shipping-method-load']//td[contains(., '')]/..//input"); // stepKey: selectShippingMethodFillAddress
		$I->waitForElement("button.button.action.continue.primary", 30); // stepKey: waitForNextButtonFillAddress
		$I->waitForPageLoad(30); // stepKey: waitForNextButtonFillAddressWaitForPageLoad
		$I->click("button.button.action.continue.primary"); // stepKey: clickNextFillAddress
		$I->waitForPageLoad(30); // stepKey: clickNextFillAddressWaitForPageLoad
		$I->waitForElement("//*[@id='checkout-payment-method-load']//div[@data-role='title']", 30); // stepKey: waitForPaymentSectionLoadedFillAddress
		$I->seeInCurrentUrl("/checkout/#payment"); // stepKey: assertCheckoutPaymentUrlFillAddress
		$I->comment("Exiting Action Group [fillAddress] GuestCheckoutFillingShippingSectionActionGroup");
		$I->waitForElement(".payment-method._active button.action.primary.checkout", 30); // stepKey: waitForPlaceOrderButtonVisible
		$I->waitForPageLoad(30); // stepKey: waitForPlaceOrderButtonVisibleWaitForPageLoad
		$I->click(".payment-method._active button.action.primary.checkout"); // stepKey: placeOrder
		$I->waitForPageLoad(30); // stepKey: placeOrderWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitUntilOrderPlaced
		$getOrderId = $I->grabTextFrom("div.checkout-success > p:nth-child(1) > span"); // stepKey: getOrderId
		$I->assertNotEmpty($getOrderId); // stepKey: assertOrderIdIsNotEmpty
		$I->comment("Find the Order on frontend > Navigate to: Orders and Returns");
		$I->amOnPage("sales/guest/form/"); // stepKey: amOnOrdersAndReturns
		$I->waitForPageLoad(30); // stepKey: waiForStorefrontPage
		$I->comment("Fill the form with correspondent Order data");
		$I->comment("Entering Action Group [fillOrder] StorefrontFillOrdersAndReturnsFormActionGroup");
		$I->fillField("#oar-order-id", $getOrderId); // stepKey: inputOrderIdFillOrder
		$I->fillField("#oar-billing-lastname", $I->retrieveEntityField('createCustomer', 'lastname', 'test')); // stepKey: inputBillingLastNameFillOrder
		$I->selectOption("#quick-search-type-id", "email"); // stepKey: selectFindOrderByEmailFillOrder
		$I->fillField("#oar_email", $I->retrieveEntityField('createCustomer', 'email', 'test')); // stepKey: inputEmailFillOrder
		$I->comment("Exiting Action Group [fillOrder] StorefrontFillOrdersAndReturnsFormActionGroup");
		$I->comment("Click on the \"Continue\" button");
		$I->click("//*/span[contains(text(), 'Continue')]"); // stepKey: clickContinue
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad
		$I->comment("Click 'Reorder' link");
		$I->click(".order-actions-toolbar .actions .order"); // stepKey: clickReturnLink
		$I->waitForPageLoad(30); // stepKey: clickReturnLinkWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad2
		$I->comment("Check that product from order is visible in cart after reorder");
		$I->seeElement("//main//table[@id='shopping-cart-table']//tbody//tr//strong[contains(@class, 'product-item-name')]//a[contains(text(), '" . $I->retrieveEntityField('createSimpleProduct', 'name', 'test') . "')]"); // stepKey: seeProductInCart
	}
}
