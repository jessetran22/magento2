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
 * @Title("MC-14717: Create Downloadable product with two links and add to the shopping cart")
 * @Description("Create Downloadable product with two links and add to the shopping cart<h3>Test files</h3>app/code/Magento/Checkout/Test/Mftf/Test/StorefrontAddDownloadableProductToShoppingCartTest.xml<br>")
 * @TestCaseId("MC-14717")
 * @group mtf_migrated
 */
class StorefrontAddDownloadableProductToShoppingCartTestCest
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
		$enableFlatRate = $I->magentoCLI("config:set carriers/flatrate/active 1", 60); // stepKey: enableFlatRate
		$I->comment($enableFlatRate);
		$enableFlatRateDefaultPrice = $I->magentoCLI("config:set carriers/flatrate/price 5.00", 60); // stepKey: enableFlatRateDefaultPrice
		$I->comment($enableFlatRateDefaultPrice);
		$I->createEntity("createDownloadableProduct", "hook", "ApiDownloadableProduct", [], []); // stepKey: createDownloadableProduct
		$I->createEntity("addDownloadableLink1", "hook", "downloadableLink1", ["createDownloadableProduct"], []); // stepKey: addDownloadableLink1
		$I->createEntity("addDownloadableLink2", "hook", "downloadableLink2", ["createDownloadableProduct"], []); // stepKey: addDownloadableLink2
		$I->comment("Adding the comment to replace CliIndexerReindexActionGroup action group ('indexer:reindex' commands) for preserving Backward Compatibility");
		$I->comment("Adding the comment to replace CliCacheFlushActionGroup action group ('cache:flush' command) for preserving Backward Compatibility");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$removeDownloadableDomain = $I->magentoCLI("downloadable:domains:remove example.com static.magento.com", 60); // stepKey: removeDownloadableDomain
		$I->comment($removeDownloadableDomain);
		$I->deleteEntity("createDownloadableProduct", "hook"); // stepKey: deleteProduct
		$I->comment("Entering Action Group [logout] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageLogout
		$I->comment("Exiting Action Group [logout] AdminLogoutActionGroup");
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
	 * @Stories({"Shopping Cart"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Features({"Checkout"})
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function StorefrontAddDownloadableProductToShoppingCartTest(AcceptanceTester $I)
	{
		$I->comment("Open Downloadable Product page");
		$I->amOnPage("/" . $I->retrieveEntityField('createDownloadableProduct', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: OpenStoreFrontProductPage
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoad
		$I->comment("Add Downloadable product to the cart");
		$I->comment("Entering Action Group [addToTheCart] StorefrontAddToCartCustomOptionsProductPageActionGroup");
		$I->click("#product-addtocart-button"); // stepKey: addToCartAddToTheCart
		$I->waitForPageLoad(60); // stepKey: addToCartAddToTheCartWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAddToTheCart
		$I->waitForElementVisible("div.message-success.success.message", 30); // stepKey: waitForSuccessMessageAddToTheCart
		$I->see("You added " . $I->retrieveEntityField('createDownloadableProduct', 'name', 'test') . " to your shopping cart.", "div.message-success.success.message"); // stepKey: seeAddToCartSuccessMessageAddToTheCart
		$I->comment("Exiting Action Group [addToTheCart] StorefrontAddToCartCustomOptionsProductPageActionGroup");
		$I->comment("Select Mini Cart and select 'View And Edit Cart'");
		$I->comment("Entering Action Group [selectViewAndEditCart] ClickViewAndEditCartFromMiniCartActionGroup");
		$I->scrollTo("a.showcart"); // stepKey: scrollToMiniCartSelectViewAndEditCart
		$I->waitForPageLoad(60); // stepKey: scrollToMiniCartSelectViewAndEditCartWaitForPageLoad
		$I->conditionalClick("a.showcart", "a.showcart.active", false); // stepKey: openMiniCartSelectViewAndEditCart
		$I->waitForElementVisible(".action.viewcart", 30); // stepKey: waitForViewAndEditCartVisibleSelectViewAndEditCart
		$I->waitForPageLoad(30); // stepKey: waitForViewAndEditCartVisibleSelectViewAndEditCartWaitForPageLoad
		$I->click(".action.viewcart"); // stepKey: viewAndEditCartSelectViewAndEditCart
		$I->waitForPageLoad(30); // stepKey: viewAndEditCartSelectViewAndEditCartWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadSelectViewAndEditCart
		$I->seeInCurrentUrl("checkout/cart"); // stepKey: seeInCurrentUrlSelectViewAndEditCart
		$I->comment("Exiting Action Group [selectViewAndEditCart] ClickViewAndEditCartFromMiniCartActionGroup");
		$I->comment("Assert Shopping Cart Summary");
		$I->comment("Entering Action Group [AssertCartSummary] AssertStorefrontShoppingCartSummaryItemsActionGroup");
		$I->seeInCurrentUrl("/checkout/cart"); // stepKey: assertUrlAssertCartSummary
		$I->waitForElementVisible("//*[@id='cart-totals']//tr[@class='totals sub']//td//span[@class='price']", 30); // stepKey: waitForSubtotalVisibleAssertCartSummary
		$I->see("$123.00", "//*[@id='cart-totals']//tr[@class='totals sub']//td//span[@class='price']"); // stepKey: assertSubtotalAssertCartSummary
		$I->waitForElementVisible("//*[@id='cart-totals']//tr[@class='grand totals']//td//span[@class='price']", 30); // stepKey: waitForTotalVisibleAssertCartSummary
		$I->waitForElementVisible("//*[@id='cart-totals']//tr[@class='grand totals']//td//span[@class='price' and contains(text(), '123.00')]", 30); // stepKey: waitForTotalAmountVisibleAssertCartSummary
		$I->see("123.00", "//*[@id='cart-totals']//tr[@class='grand totals']//td//span[@class='price']"); // stepKey: assertTotalAssertCartSummary
		$I->seeElement(".action.primary.checkout span"); // stepKey: seeProceedToCheckoutButtonAssertCartSummary
		$I->waitForPageLoad(30); // stepKey: seeProceedToCheckoutButtonAssertCartSummaryWaitForPageLoad
		$I->comment("Exiting Action Group [AssertCartSummary] AssertStorefrontShoppingCartSummaryItemsActionGroup");
		$I->comment("Assert Product Details In Checkout cart");
		$I->comment("Entering Action Group [assertProductItemInCheckOutCart] AssertStorefrontCheckoutCartItemsActionGroup");
		$I->waitForElementVisible("//tbody[@class='cart item']//strong[@class='product-item-name']", 60); // stepKey: waitForProductNameVisibleAssertProductItemInCheckOutCart
		$I->see($I->retrieveEntityField('createDownloadableProduct', 'name', 'test'), "//tbody[@class='cart item']//strong[@class='product-item-name']"); // stepKey: seeProductNameInCheckoutSummaryAssertProductItemInCheckOutCart
		$I->see("$123.00", "//main//table[@id='shopping-cart-table']//tbody//tr[..//strong[contains(@class, 'product-item-name')]//a/text()='" . $I->retrieveEntityField('createDownloadableProduct', 'name', 'test') . "'][1]//td[contains(@class, 'price')]//span[@class='price']"); // stepKey: seeProductPriceInCartAssertProductItemInCheckOutCart
		$I->see("$123.00", "//main//table[@id='shopping-cart-table']//tbody//tr[..//strong[contains(@class, 'product-item-name')]//a/text()='" . $I->retrieveEntityField('createDownloadableProduct', 'name', 'test') . "'][1]//td[contains(@class, 'subtotal')]//span[@class='price']"); // stepKey: seeSubtotalPriceAssertProductItemInCheckOutCart
		$I->seeInField("//main//table[@id='shopping-cart-table']//tbody//tr[..//strong[contains(@class, 'product-item-name')]//a/text()='" . $I->retrieveEntityField('createDownloadableProduct', 'name', 'test') . "'][1]//td[contains(@class, 'qty')]//input[contains(@class, 'qty')]", "1"); // stepKey: seeProductQuantityAssertProductItemInCheckOutCart
		$I->comment("Exiting Action Group [assertProductItemInCheckOutCart] AssertStorefrontCheckoutCartItemsActionGroup");
		$I->comment("Entering Action Group [seeLinksInCart] AssertStorefrontElementVisibleActionGroup");
		$I->waitForElementVisible("//dl[@class='item-options']", 60); // stepKey: waitForElementVisibleSeeLinksInCart
		$I->see("Links", "//dl[@class='item-options']"); // stepKey: assertElementSeeLinksInCart
		$I->comment("Exiting Action Group [seeLinksInCart] AssertStorefrontElementVisibleActionGroup");
		$I->comment("Entering Action Group [seeProductOptionLink1] AssertStorefrontElementVisibleActionGroup");
		$I->waitForElementVisible("//dl[@class='item-options']", 60); // stepKey: waitForElementVisibleSeeProductOptionLink1
		$I->see("link-1" . msq("downloadableLink1"), "//dl[@class='item-options']"); // stepKey: assertElementSeeProductOptionLink1
		$I->comment("Exiting Action Group [seeProductOptionLink1] AssertStorefrontElementVisibleActionGroup");
		$I->comment("Entering Action Group [seeProductOptionLink2] AssertStorefrontElementVisibleActionGroup");
		$I->waitForElementVisible("//dl[@class='item-options']", 60); // stepKey: waitForElementVisibleSeeProductOptionLink2
		$I->see("link-2" . msq("downloadableLink2"), "//dl[@class='item-options']"); // stepKey: assertElementSeeProductOptionLink2
		$I->comment("Exiting Action Group [seeProductOptionLink2] AssertStorefrontElementVisibleActionGroup");
		$I->comment("Assert product details in Mini Cart");
		$I->comment("Entering Action Group [clickOnMiniCart] StorefrontClickOnMiniCartActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollToTheTopOfThePageClickOnMiniCart
		$I->waitForElementVisible("a.showcart", 30); // stepKey: waitForElementToBeVisibleClickOnMiniCart
		$I->waitForPageLoad(60); // stepKey: waitForElementToBeVisibleClickOnMiniCartWaitForPageLoad
		$I->click("a.showcart"); // stepKey: clickOnMiniCartClickOnMiniCart
		$I->waitForPageLoad(60); // stepKey: clickOnMiniCartClickOnMiniCartWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadClickOnMiniCart
		$I->comment("Exiting Action Group [clickOnMiniCart] StorefrontClickOnMiniCartActionGroup");
		$I->comment("Entering Action Group [assertMiniCart] AssertStorefrontMiniCartItemsActionGroup");
		$I->see("$123.00", ".minicart-items"); // stepKey: seeProductPriceInMiniCartAssertMiniCart
		$I->seeElement("#top-cart-btn-checkout"); // stepKey: seeCheckOutButtonInMiniCartAssertMiniCart
		$I->waitForPageLoad(30); // stepKey: seeCheckOutButtonInMiniCartAssertMiniCartWaitForPageLoad
		$I->seeElement("//*[@id='mini-cart']//a[contains(text(),'" . $I->retrieveEntityField('createDownloadableProduct', 'name', 'test') . "')]/../..//div[@class='details-qty qty']//input[@data-item-qty='1']"); // stepKey: seeProductQuantity1AssertMiniCart
		$I->seeElement("//ol[@id='mini-cart']//img[@class='product-image-photo']"); // stepKey: seeProductImageAssertMiniCart
		$I->see("123.00", "//div[@class='subtotal']//span/span[@class='price']"); // stepKey: seeSubTotalAssertMiniCart
		$I->see($I->retrieveEntityField('createDownloadableProduct', 'name', 'test'), ".minicart-items"); // stepKey: seeProductNameInMiniCartAssertMiniCart
		$I->comment("Exiting Action Group [assertMiniCart] AssertStorefrontMiniCartItemsActionGroup");
	}
}
