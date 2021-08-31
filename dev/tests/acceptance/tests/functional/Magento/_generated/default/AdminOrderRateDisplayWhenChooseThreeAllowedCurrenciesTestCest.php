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
 * @Title("MC-17255: Order rate converting currency for 'Base Currency' and 'Default Display Currency' displayed correct")
 * @Description("Order rate converting currency for 'Base Currency' and 'Default Display Currency' displayed correct<h3>Test files</h3>app/code/Magento/CurrencySymbol/Test/Mftf/Test/AdminOrderRateDisplayWhenChooseThreeAllowedCurrenciesTest.xml<br>")
 * @TestCaseId("MC-17255")
 * @group currency
 */
class AdminOrderRateDisplayWhenChooseThreeAllowedCurrenciesTestCest
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
		$I->comment("Entering Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsAdmin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginAsAdmin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginAsAdmin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsAdmin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsAdminWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsAdmin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsAdmin
		$I->comment("Exiting Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->comment("Create product");
		$I->createEntity("createProduct", "hook", "SimpleProduct2", [], []); // stepKey: createProduct
		$I->comment("Set price scope website");
		$setCatalogPriceScopeWebsite = $I->magentoCLI("config:set catalog/price/scope 1", 60); // stepKey: setCatalogPriceScopeWebsite
		$I->comment($setCatalogPriceScopeWebsite);
		$I->comment("Set Currency options for Default Config");
		$setCurrencyBaseEUR = $I->magentoCLI("config:set currency/options/base EUR", 60); // stepKey: setCurrencyBaseEUR
		$I->comment($setCurrencyBaseEUR);
		$setAllowedCurrencyEURandUSD = $I->magentoCLI("config:set currency/options/allow USD,EUR", 60); // stepKey: setAllowedCurrencyEURandUSD
		$I->comment($setAllowedCurrencyEURandUSD);
		$setCurrencyDefaultEUR = $I->magentoCLI("config:set currency/options/default EUR", 60); // stepKey: setCurrencyDefaultEUR
		$I->comment($setCurrencyDefaultEUR);
		$I->comment("Set Currency options for Website");
		$setCurrencyBaseEURWebsites = $I->magentoCLI("config:set --scope=websites --scope-code=base currency/options/base USD", 60); // stepKey: setCurrencyBaseEURWebsites
		$I->comment($setCurrencyBaseEURWebsites);
		$setAllowedCurrencyWebsitesForEURandUSD = $I->magentoCLI("config:set --scope=websites --scope-code=base currency/options/allow USD,EUR", 60); // stepKey: setAllowedCurrencyWebsitesForEURandUSD
		$I->comment($setAllowedCurrencyWebsitesForEURandUSD);
		$setCurrencyDefaultEURWebsites = $I->magentoCLI("config:set --scope=websites --scope-code=base currency/options/default EUR", 60); // stepKey: setCurrencyDefaultEURWebsites
		$I->comment($setCurrencyDefaultEURWebsites);
		$I->comment("Create product");
		$I->createEntity("createNewProduct", "hook", "SimpleProduct2", [], []); // stepKey: createNewProduct
		$I->comment("Set Currency options for Website");
		$setCurrencyBaseUSDWebsites = $I->magentoCLI("config:set --scope=websites --scope-code=base currency/options/base USD", 60); // stepKey: setCurrencyBaseUSDWebsites
		$I->comment($setCurrencyBaseUSDWebsites);
		$setAllowedCurrencyWebsitesEURandRUBandUSD = $I->magentoCLI("config:set --scope=websites --scope-code=base currency/options/allow USD,EUR,RUB", 60); // stepKey: setAllowedCurrencyWebsitesEURandRUBandUSD
		$I->comment($setAllowedCurrencyWebsitesEURandRUBandUSD);
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Delete created product");
		$I->deleteEntity("createProduct", "hook"); // stepKey: deleteProduct
		$I->comment("Reset configurations");
		$setCatalogPriceScopeGlobal = $I->magentoCLI("config:set catalog/price/scope 0", 60); // stepKey: setCatalogPriceScopeGlobal
		$I->comment($setCatalogPriceScopeGlobal);
		$setCurrencyBaseUSD = $I->magentoCLI("config:set currency/options/base USD", 60); // stepKey: setCurrencyBaseUSD
		$I->comment($setCurrencyBaseUSD);
		$setCurrencyDefaultUSD = $I->magentoCLI("config:set currency/options/default USD", 60); // stepKey: setCurrencyDefaultUSD
		$I->comment($setCurrencyDefaultUSD);
		$setAllowedCurrencyUSD = $I->magentoCLI("config:set currency/options/allow USD", 60); // stepKey: setAllowedCurrencyUSD
		$I->comment($setAllowedCurrencyUSD);
		$I->comment("Set Currency options for Website");
		$setCurrencyBaseUSDWebsites = $I->magentoCLI("config:set --scope=websites --scope-code=base currency/options/base USD", 60); // stepKey: setCurrencyBaseUSDWebsites
		$I->comment($setCurrencyBaseUSDWebsites);
		$setCurrencyDefaultUSDWebsites = $I->magentoCLI("config:set --scope=websites --scope-code=base currency/options/default USD", 60); // stepKey: setCurrencyDefaultUSDWebsites
		$I->comment($setCurrencyDefaultUSDWebsites);
		$setAllowedCurrencyUSDWebsites = $I->magentoCLI("config:set --scope=websites --scope-code=base currency/options/allow USD", 60); // stepKey: setAllowedCurrencyUSDWebsites
		$I->comment($setAllowedCurrencyUSDWebsites);
		$I->comment("Entering Action Group [logout] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageLogout
		$I->comment("Exiting Action Group [logout] AdminLogoutActionGroup");
		$I->comment("Delete created product");
		$I->comment("Delete created product");
		$I->deleteEntity("createNewProduct", "hook"); // stepKey: deleteNewProduct
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
	 * @Features({"CurrencySymbol"})
	 * @Stories({"Currency rates order page"})
	 * @Severity(level = SeverityLevel::NORMAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminOrderRateDisplayWhenChooseThreeAllowedCurrenciesTest(AcceptanceTester $I)
	{
		$I->comment("Open created product on Storefront and place for order");
		$I->amOnPage("/" . $I->retrieveEntityField('createProduct', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: goToProductPage
		$I->waitForPageLoad(30); // stepKey: waitForProductPagePageLoad
		$I->comment("Entering Action Group [addToCartFromStorefrontProductPage] AddToCartFromStorefrontProductPageActionGroup");
		$I->click("#product-addtocart-button"); // stepKey: addToCartAddToCartFromStorefrontProductPage
		$I->waitForPageLoad(60); // stepKey: addToCartAddToCartFromStorefrontProductPageWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForAddToCartAddToCartFromStorefrontProductPage
		$I->waitForElementNotVisible("//button/span[text()='Adding...']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddingAddToCartFromStorefrontProductPage
		$I->waitForElementNotVisible("//button/span[text()='Added']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddedAddToCartFromStorefrontProductPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAddToCartFromStorefrontProductPage
		$I->waitForElementVisible("div.message-success.success.message", 30); // stepKey: waitForSuccessMessageAddToCartFromStorefrontProductPage
		$I->see("You added " . $I->retrieveEntityField('createProduct', 'name', 'test') . " to your shopping cart.", "div.message-success.success.message"); // stepKey: seeAddToCartSuccessMessageAddToCartFromStorefrontProductPage
		$I->comment("Exiting Action Group [addToCartFromStorefrontProductPage] AddToCartFromStorefrontProductPageActionGroup");
		$I->comment("Entering Action Group [guestGoToCheckoutFromMinicart] GoToCheckoutFromMinicartActionGroup");
		$I->waitForElementNotVisible(".counter.qty.empty", 30); // stepKey: waitUpdateQuantityGuestGoToCheckoutFromMinicart
		$I->wait(5); // stepKey: waitMinicartRenderingGuestGoToCheckoutFromMinicart
		$I->click("a.showcart"); // stepKey: clickCartGuestGoToCheckoutFromMinicart
		$I->waitForPageLoad(60); // stepKey: clickCartGuestGoToCheckoutFromMinicartWaitForPageLoad
		$I->click("#top-cart-btn-checkout"); // stepKey: goToCheckoutGuestGoToCheckoutFromMinicart
		$I->waitForPageLoad(30); // stepKey: goToCheckoutGuestGoToCheckoutFromMinicartWaitForPageLoad
		$I->comment("Exiting Action Group [guestGoToCheckoutFromMinicart] GoToCheckoutFromMinicartActionGroup");
		$I->comment("Entering Action Group [guestCheckoutFillingShippingSection] GuestCheckoutFillingShippingSectionActionGroup");
		$I->waitForElementVisible("input[id*=customer-email]", 30); // stepKey: waitForEmailFieldGuestCheckoutFillingShippingSection
		$I->fillField("input[id*=customer-email]", msq("CustomerEntityOne") . "test@email.com"); // stepKey: enterEmailGuestCheckoutFillingShippingSection
		$I->fillField("input[name=firstname]", "John"); // stepKey: enterFirstNameGuestCheckoutFillingShippingSection
		$I->fillField("input[name=lastname]", "Doe"); // stepKey: enterLastNameGuestCheckoutFillingShippingSection
		$I->fillField("input[name='street[0]']", "7700 W Parmer Ln"); // stepKey: enterStreetGuestCheckoutFillingShippingSection
		$I->fillField("input[name=city]", "Austin"); // stepKey: enterCityGuestCheckoutFillingShippingSection
		$I->selectOption("select[name=region_id]", "Texas"); // stepKey: selectRegionGuestCheckoutFillingShippingSection
		$I->fillField("input[name=postcode]", "78729"); // stepKey: enterPostcodeGuestCheckoutFillingShippingSection
		$I->fillField("input[name=telephone]", "1234568910"); // stepKey: enterTelephoneGuestCheckoutFillingShippingSection
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskGuestCheckoutFillingShippingSection
		$I->waitForElement("//div[@id='checkout-shipping-method-load']//td[contains(., '')]/..//input", 30); // stepKey: waitForShippingMethodGuestCheckoutFillingShippingSection
		$I->click("//div[@id='checkout-shipping-method-load']//td[contains(., '')]/..//input"); // stepKey: selectShippingMethodGuestCheckoutFillingShippingSection
		$I->waitForElement("button.button.action.continue.primary", 30); // stepKey: waitForNextButtonGuestCheckoutFillingShippingSection
		$I->waitForPageLoad(30); // stepKey: waitForNextButtonGuestCheckoutFillingShippingSectionWaitForPageLoad
		$I->click("button.button.action.continue.primary"); // stepKey: clickNextGuestCheckoutFillingShippingSection
		$I->waitForPageLoad(30); // stepKey: clickNextGuestCheckoutFillingShippingSectionWaitForPageLoad
		$I->waitForElement("//*[@id='checkout-payment-method-load']//div[@data-role='title']", 30); // stepKey: waitForPaymentSectionLoadedGuestCheckoutFillingShippingSection
		$I->seeInCurrentUrl("/checkout/#payment"); // stepKey: assertCheckoutPaymentUrlGuestCheckoutFillingShippingSection
		$I->comment("Exiting Action Group [guestCheckoutFillingShippingSection] GuestCheckoutFillingShippingSectionActionGroup");
		$I->comment("Entering Action Group [guestSelectCheckMoneyOrderPayment] CheckoutSelectCheckMoneyOrderPaymentActionGroup");
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskGuestSelectCheckMoneyOrderPayment
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadGuestSelectCheckMoneyOrderPayment
		$I->conditionalClick("//div[@id='checkout-payment-method-load']//div[@class='payment-method']//label//span[contains(., 'Check / Money order')]/../..//input", "//div[@id='checkout-payment-method-load']//div[@class='payment-method']//label//span[contains(., 'Check / Money order')]/../..//input", true); // stepKey: selectCheckmoPaymentMethodGuestSelectCheckMoneyOrderPayment
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskAfterPaymentMethodSelectionGuestSelectCheckMoneyOrderPayment
		$I->comment("Exiting Action Group [guestSelectCheckMoneyOrderPayment] CheckoutSelectCheckMoneyOrderPaymentActionGroup");
		$I->comment("Entering Action Group [guestPlaceOrder] CheckoutPlaceOrderActionGroup");
		$I->waitForElementVisible(".payment-method._active button.action.primary.checkout", 30); // stepKey: waitForPlaceOrderButtonGuestPlaceOrder
		$I->waitForPageLoad(30); // stepKey: waitForPlaceOrderButtonGuestPlaceOrderWaitForPageLoad
		$I->click(".payment-method._active button.action.primary.checkout"); // stepKey: clickPlaceOrderGuestPlaceOrder
		$I->waitForPageLoad(30); // stepKey: clickPlaceOrderGuestPlaceOrderWaitForPageLoad
		$I->see("Your order # is:", "div.checkout-success"); // stepKey: seeOrderNumberGuestPlaceOrder
		$I->see("We'll email you an order confirmation with details and tracking info.", "div.checkout-success"); // stepKey: seeEmailYouGuestPlaceOrder
		$I->comment("Exiting Action Group [guestPlaceOrder] CheckoutPlaceOrderActionGroup");
		$grabOrderNumber = $I->grabTextFrom("div.checkout-success > p:nth-child(1) > span"); // stepKey: grabOrderNumber
		$I->comment("Open order and check rates display in one line");
		$I->comment("Entering Action Group [openOrderById] OpenOrderByIdActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/sales/order/"); // stepKey: navigateToOrderGridPageOpenOrderById
		$I->waitForPageLoad(30); // stepKey: waitForOrdersPageOpenOrderById
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clearExistingOrderFiltersOpenOrderById
		$I->waitForPageLoad(30); // stepKey: clearExistingOrderFiltersOpenOrderByIdWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForClearFiltersOpenOrderById
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openOrderGridFiltersOpenOrderById
		$I->waitForPageLoad(30); // stepKey: openOrderGridFiltersOpenOrderByIdWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForClickFiltersOpenOrderById
		$I->fillField(".admin__data-grid-filters input[name='increment_id']", "$grabOrderNumber"); // stepKey: fillOrderIdFilterOpenOrderById
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickOrderApplyFiltersOpenOrderById
		$I->waitForPageLoad(30); // stepKey: clickOrderApplyFiltersOpenOrderByIdWaitForPageLoad
		$I->click("table.data-grid tbody > tr:nth-of-type(1)"); // stepKey: openOrderViewPageOpenOrderById
		$I->waitForPageLoad(60); // stepKey: openOrderViewPageOpenOrderByIdWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForOrderViewPageOpenedOpenOrderById
		$I->waitForPageLoad(30); // stepKey: waitForApplyFiltersOpenOrderById
		$I->comment("Exiting Action Group [openOrderById] OpenOrderByIdActionGroup");
		$I->see("EUR / USD rate", ".order-information-table"); // stepKey: seeEURandUSDRate
		$grabRate = $I->grabMultiple("//table[contains(@class, 'order-information-table')]//th[contains(text(), 'rate:')]"); // stepKey: grabRate
		$I->assertEquals(["EUR / USD rate:"], $grabRate); // stepKey: assertSelectedCategories
		$I->comment("Set currency rates");
		$I->comment("Entering Action Group [gotToCurrencyRatesPageSecondTime] AdminOpenCurrencyRatesPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_currency/"); // stepKey: openCurrencyRatesPageGotToCurrencyRatesPageSecondTime
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadGotToCurrencyRatesPageSecondTime
		$I->comment("Exiting Action Group [gotToCurrencyRatesPageSecondTime] AdminOpenCurrencyRatesPageActionGroup");
		$I->comment("Adding the comment to replace action for preserving Backward Compatibility");
		$I->comment("Entering Action Group [setCurrencyRates] AdminSetCurrencyRatesActionGroup");
		$I->fillField("input[name='rate[USD][RUB]']", "0.8"); // stepKey: setCurrencyRateSetCurrencyRates
		$I->click("//button[@title='Save Currency Rates']"); // stepKey: clickSaveCurrencyRatesSetCurrencyRates
		$I->waitForPageLoad(30); // stepKey: waitForSaveSetCurrencyRates
		$I->see("All valid rates have been saved.", "#messages div.message-success"); // stepKey: seeSuccessMessageSetCurrencyRates
		$I->comment("Exiting Action Group [setCurrencyRates] AdminSetCurrencyRatesActionGroup");
		$I->comment("Open created product on Storefront and place for order");
		$I->amOnPage("/" . $I->retrieveEntityField('createNewProduct', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: goToNewProductPage
		$I->waitForPageLoad(30); // stepKey: waitForNewProductPagePageLoad
		$I->comment("Entering Action Group [switchCurrency] StorefrontSwitchCurrencyActionGroup");
		$I->click("#switcher-currency-trigger"); // stepKey: openToggleSwitchCurrency
		$I->waitForPageLoad(30); // stepKey: openToggleSwitchCurrencyWaitForPageLoad
		$I->waitForElementVisible("//div[@id='switcher-currency-trigger']/following-sibling::ul//a[contains(text(), 'RUB')]", 30); // stepKey: waitForCurrencySwitchCurrency
		$I->waitForPageLoad(10); // stepKey: waitForCurrencySwitchCurrencyWaitForPageLoad
		$I->click("//div[@id='switcher-currency-trigger']/following-sibling::ul//a[contains(text(), 'RUB')]"); // stepKey: chooseCurrencySwitchCurrency
		$I->waitForPageLoad(10); // stepKey: chooseCurrencySwitchCurrencyWaitForPageLoad
		$I->see("RUB", "#switcher-currency-trigger span"); // stepKey: seeSelectedCurrencySwitchCurrency
		$I->comment("Exiting Action Group [switchCurrency] StorefrontSwitchCurrencyActionGroup");
		$I->comment("Entering Action Group [addToCartFromStorefrontNewProductPage] AddToCartFromStorefrontProductPageActionGroup");
		$I->click("#product-addtocart-button"); // stepKey: addToCartAddToCartFromStorefrontNewProductPage
		$I->waitForPageLoad(60); // stepKey: addToCartAddToCartFromStorefrontNewProductPageWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForAddToCartAddToCartFromStorefrontNewProductPage
		$I->waitForElementNotVisible("//button/span[text()='Adding...']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddingAddToCartFromStorefrontNewProductPage
		$I->waitForElementNotVisible("//button/span[text()='Added']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddedAddToCartFromStorefrontNewProductPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAddToCartFromStorefrontNewProductPage
		$I->waitForElementVisible("div.message-success.success.message", 30); // stepKey: waitForSuccessMessageAddToCartFromStorefrontNewProductPage
		$I->see("You added " . $I->retrieveEntityField('createNewProduct', 'name', 'test') . " to your shopping cart.", "div.message-success.success.message"); // stepKey: seeAddToCartSuccessMessageAddToCartFromStorefrontNewProductPage
		$I->comment("Exiting Action Group [addToCartFromStorefrontNewProductPage] AddToCartFromStorefrontProductPageActionGroup");
		$I->comment("Entering Action Group [guestGoToCheckoutNewProductFromMinicart] GoToCheckoutFromMinicartActionGroup");
		$I->waitForElementNotVisible(".counter.qty.empty", 30); // stepKey: waitUpdateQuantityGuestGoToCheckoutNewProductFromMinicart
		$I->wait(5); // stepKey: waitMinicartRenderingGuestGoToCheckoutNewProductFromMinicart
		$I->click("a.showcart"); // stepKey: clickCartGuestGoToCheckoutNewProductFromMinicart
		$I->waitForPageLoad(60); // stepKey: clickCartGuestGoToCheckoutNewProductFromMinicartWaitForPageLoad
		$I->click("#top-cart-btn-checkout"); // stepKey: goToCheckoutGuestGoToCheckoutNewProductFromMinicart
		$I->waitForPageLoad(30); // stepKey: goToCheckoutGuestGoToCheckoutNewProductFromMinicartWaitForPageLoad
		$I->comment("Exiting Action Group [guestGoToCheckoutNewProductFromMinicart] GoToCheckoutFromMinicartActionGroup");
		$I->comment("Entering Action Group [guestCheckoutNewFillingShippingSection] GuestCheckoutFillingShippingSectionActionGroup");
		$I->waitForElementVisible("input[id*=customer-email]", 30); // stepKey: waitForEmailFieldGuestCheckoutNewFillingShippingSection
		$I->fillField("input[id*=customer-email]", msq("CustomerEntityOne") . "test@email.com"); // stepKey: enterEmailGuestCheckoutNewFillingShippingSection
		$I->fillField("input[name=firstname]", "John"); // stepKey: enterFirstNameGuestCheckoutNewFillingShippingSection
		$I->fillField("input[name=lastname]", "Doe"); // stepKey: enterLastNameGuestCheckoutNewFillingShippingSection
		$I->fillField("input[name='street[0]']", "7700 W Parmer Ln"); // stepKey: enterStreetGuestCheckoutNewFillingShippingSection
		$I->fillField("input[name=city]", "Austin"); // stepKey: enterCityGuestCheckoutNewFillingShippingSection
		$I->selectOption("select[name=region_id]", "Texas"); // stepKey: selectRegionGuestCheckoutNewFillingShippingSection
		$I->fillField("input[name=postcode]", "78729"); // stepKey: enterPostcodeGuestCheckoutNewFillingShippingSection
		$I->fillField("input[name=telephone]", "1234568910"); // stepKey: enterTelephoneGuestCheckoutNewFillingShippingSection
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskGuestCheckoutNewFillingShippingSection
		$I->waitForElement("//div[@id='checkout-shipping-method-load']//td[contains(., '')]/..//input", 30); // stepKey: waitForShippingMethodGuestCheckoutNewFillingShippingSection
		$I->click("//div[@id='checkout-shipping-method-load']//td[contains(., '')]/..//input"); // stepKey: selectShippingMethodGuestCheckoutNewFillingShippingSection
		$I->waitForElement("button.button.action.continue.primary", 30); // stepKey: waitForNextButtonGuestCheckoutNewFillingShippingSection
		$I->waitForPageLoad(30); // stepKey: waitForNextButtonGuestCheckoutNewFillingShippingSectionWaitForPageLoad
		$I->click("button.button.action.continue.primary"); // stepKey: clickNextGuestCheckoutNewFillingShippingSection
		$I->waitForPageLoad(30); // stepKey: clickNextGuestCheckoutNewFillingShippingSectionWaitForPageLoad
		$I->waitForElement("//*[@id='checkout-payment-method-load']//div[@data-role='title']", 30); // stepKey: waitForPaymentSectionLoadedGuestCheckoutNewFillingShippingSection
		$I->seeInCurrentUrl("/checkout/#payment"); // stepKey: assertCheckoutPaymentUrlGuestCheckoutNewFillingShippingSection
		$I->comment("Exiting Action Group [guestCheckoutNewFillingShippingSection] GuestCheckoutFillingShippingSectionActionGroup");
		$I->comment("Entering Action Group [guestSelectNewCheckMoneyOrderPayment] CheckoutSelectCheckMoneyOrderPaymentActionGroup");
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskGuestSelectNewCheckMoneyOrderPayment
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadGuestSelectNewCheckMoneyOrderPayment
		$I->conditionalClick("//div[@id='checkout-payment-method-load']//div[@class='payment-method']//label//span[contains(., 'Check / Money order')]/../..//input", "//div[@id='checkout-payment-method-load']//div[@class='payment-method']//label//span[contains(., 'Check / Money order')]/../..//input", true); // stepKey: selectCheckmoPaymentMethodGuestSelectNewCheckMoneyOrderPayment
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskAfterPaymentMethodSelectionGuestSelectNewCheckMoneyOrderPayment
		$I->comment("Exiting Action Group [guestSelectNewCheckMoneyOrderPayment] CheckoutSelectCheckMoneyOrderPaymentActionGroup");
		$I->comment("Entering Action Group [guestPlaceNewOrder] CheckoutPlaceOrderActionGroup");
		$I->waitForElementVisible(".payment-method._active button.action.primary.checkout", 30); // stepKey: waitForPlaceOrderButtonGuestPlaceNewOrder
		$I->waitForPageLoad(30); // stepKey: waitForPlaceOrderButtonGuestPlaceNewOrderWaitForPageLoad
		$I->click(".payment-method._active button.action.primary.checkout"); // stepKey: clickPlaceOrderGuestPlaceNewOrder
		$I->waitForPageLoad(30); // stepKey: clickPlaceOrderGuestPlaceNewOrderWaitForPageLoad
		$I->see("Your order # is:", "div.checkout-success"); // stepKey: seeOrderNumberGuestPlaceNewOrder
		$I->see("We'll email you an order confirmation with details and tracking info.", "div.checkout-success"); // stepKey: seeEmailYouGuestPlaceNewOrder
		$I->comment("Exiting Action Group [guestPlaceNewOrder] CheckoutPlaceOrderActionGroup");
		$grabNewOrderNumber = $I->grabTextFrom("div.checkout-success > p:nth-child(1) > span"); // stepKey: grabNewOrderNumber
		$I->comment("Open order and check rates display in one line");
		$I->comment("Entering Action Group [openNewOrderById] OpenOrderByIdActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/sales/order/"); // stepKey: navigateToOrderGridPageOpenNewOrderById
		$I->waitForPageLoad(30); // stepKey: waitForOrdersPageOpenNewOrderById
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clearExistingOrderFiltersOpenNewOrderById
		$I->waitForPageLoad(30); // stepKey: clearExistingOrderFiltersOpenNewOrderByIdWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForClearFiltersOpenNewOrderById
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openOrderGridFiltersOpenNewOrderById
		$I->waitForPageLoad(30); // stepKey: openOrderGridFiltersOpenNewOrderByIdWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForClickFiltersOpenNewOrderById
		$I->fillField(".admin__data-grid-filters input[name='increment_id']", "$grabNewOrderNumber"); // stepKey: fillOrderIdFilterOpenNewOrderById
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickOrderApplyFiltersOpenNewOrderById
		$I->waitForPageLoad(30); // stepKey: clickOrderApplyFiltersOpenNewOrderByIdWaitForPageLoad
		$I->click("table.data-grid tbody > tr:nth-of-type(1)"); // stepKey: openOrderViewPageOpenNewOrderById
		$I->waitForPageLoad(60); // stepKey: openOrderViewPageOpenNewOrderByIdWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForOrderViewPageOpenedOpenNewOrderById
		$I->waitForPageLoad(30); // stepKey: waitForApplyFiltersOpenNewOrderById
		$I->comment("Exiting Action Group [openNewOrderById] OpenOrderByIdActionGroup");
		$I->see("EUR / USD rate", ".order-information-table"); // stepKey: seeUSDandEURRate
		$I->see("RUB / USD rate:", ".order-information-table"); // stepKey: seeRUBandEURRate
		$grabRates = $I->grabMultiple("//table[contains(@class, 'order-information-table')]//th[contains(text(), 'rate:')]"); // stepKey: grabRates
		$I->assertEquals(['EUR / USD rate:',  'RUB / USD rate:'], $grabRates); // stepKey: assertRates
	}
}
