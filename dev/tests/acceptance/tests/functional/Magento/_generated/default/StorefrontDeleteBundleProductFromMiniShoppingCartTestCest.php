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
 * @Title("MC-14682: Storefront Delete Bundle Product From Mini Shopping Cart Test")
 * @Description("Test log in to Shopping Cart and Delete Bundle Product From Mini Shopping Cart Test<h3>Test files</h3>app/code/Magento/Checkout/Test/Mftf/Test/StorefrontDeleteBundleProductFromMiniShoppingCartTest.xml<br>")
 * @TestCaseId("MC-14682")
 * @group Shopping Cart
 * @group mtf_migrated
 */
class StorefrontDeleteBundleProductFromMiniShoppingCartTestCest
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
		$I->comment("Entering Action Group [LoginAsAdmin] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsAdmin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginAsAdmin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginAsAdmin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsAdmin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsAdminWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsAdmin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsAdmin
		$I->comment("Exiting Action Group [LoginAsAdmin] AdminLoginActionGroup");
		$enableFlatRate = $I->magentoCLI("config:set carriers/flatrate/active 1", 60); // stepKey: enableFlatRate
		$I->comment($enableFlatRate);
		$enableFlatRateDefaultPrice = $I->magentoCLI("config:set carriers/flatrate/price 5.00", 60); // stepKey: enableFlatRateDefaultPrice
		$I->comment($enableFlatRateDefaultPrice);
		$I->createEntity("createSubCategory", "hook", "SimpleSubCategory", [], []); // stepKey: createSubCategory
		$I->comment("Create  simple product");
		$simpleProduct1Fields['price'] = "10.00";
		$I->createEntity("simpleProduct1", "hook", "SimpleProduct2", [], $simpleProduct1Fields); // stepKey: simpleProduct1
		$I->comment("Create Bundle product");
		$I->createEntity("createBundleProduct", "hook", "BundleProductPriceViewRange", ["createSubCategory"], []); // stepKey: createBundleProduct
		$createBundleOption1_1Fields['required'] = "True";
		$I->createEntity("createBundleOption1_1", "hook", "DropDownBundleOption", ["createBundleProduct"], $createBundleOption1_1Fields); // stepKey: createBundleOption1_1
		$I->createEntity("linkOptionToProduct", "hook", "ApiBundleLink", ["createBundleProduct", "createBundleOption1_1", "simpleProduct1"], []); // stepKey: linkOptionToProduct
		$I->comment("Entering Action Group [reindex] CliIndexerReindexActionGroup");
		$reindexSpecifiedIndexersReindex = $I->magentoCLI("indexer:reindex", 60, "cataloginventory_stock"); // stepKey: reindexSpecifiedIndexersReindex
		$I->comment($reindexSpecifiedIndexersReindex);
		$I->comment("Exiting Action Group [reindex] CliIndexerReindexActionGroup");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->deleteEntity("simpleProduct1", "hook"); // stepKey: deleteProduct1
		$I->deleteEntity("createBundleProduct", "hook"); // stepKey: deleteBundleProduct
		$I->deleteEntity("createSubCategory", "hook"); // stepKey: deleteCategory
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
	 * @Stories({"DeleteBundleProduct"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Features({"Checkout"})
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function StorefrontDeleteBundleProductFromMiniShoppingCartTest(AcceptanceTester $I)
	{
		$I->comment("Open Product page in StoreFront");
		$I->comment("Entering Action Group [openProductPageAndVerifyProduct] AssertProductNameAndSkuInStorefrontProductPageByCustomAttributeUrlKeyActionGroup");
		$I->comment("Go to storefront product page, assert product name and sku");
		$I->amOnPage($I->retrieveEntityField('createBundleProduct', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: navigateToProductPageOpenProductPageAndVerifyProduct
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad2OpenProductPageAndVerifyProduct
		$I->seeInTitle($I->retrieveEntityField('createBundleProduct', 'name', 'test')); // stepKey: assertProductNameTitleOpenProductPageAndVerifyProduct
		$I->see($I->retrieveEntityField('createBundleProduct', 'name', 'test'), ".base"); // stepKey: assertProductNameOpenProductPageAndVerifyProduct
		$I->see($I->retrieveEntityField('createBundleProduct', 'sku', 'test'), ".product.attribute.sku>.value"); // stepKey: assertProductSkuOpenProductPageAndVerifyProduct
		$I->comment("Exiting Action Group [openProductPageAndVerifyProduct] AssertProductNameAndSkuInStorefrontProductPageByCustomAttributeUrlKeyActionGroup");
		$I->comment("Click on customize And Add To Cart Button");
		$I->comment("Entering Action Group [clickOnCustomizeAndAddtoCartButton] StorefrontSelectCustomizeAndAddToTheCartButtonActionGroup");
		$I->waitForElementVisible("#bundle-slide", 30); // stepKey: waitForCustomizeAndAddToCartButtonClickOnCustomizeAndAddtoCartButton
		$I->waitForPageLoad(30); // stepKey: waitForCustomizeAndAddToCartButtonClickOnCustomizeAndAddtoCartButtonWaitForPageLoad
		$I->click("#bundle-slide"); // stepKey: clickOnCustomizeAndAddToCartButtonClickOnCustomizeAndAddtoCartButton
		$I->waitForPageLoad(30); // stepKey: clickOnCustomizeAndAddToCartButtonClickOnCustomizeAndAddtoCartButtonWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadClickOnCustomizeAndAddtoCartButton
		$I->comment("Exiting Action Group [clickOnCustomizeAndAddtoCartButton] StorefrontSelectCustomizeAndAddToTheCartButtonActionGroup");
		$I->comment("Select Product Quantity and add to the cart");
		$I->comment("Entering Action Group [enterProductQuantityAndAddToTheCart] StorefrontEnterProductQuantityAndAddToTheCartActionGroup");
		$I->clearField("#qty"); // stepKey: clearTheQuantityFieldEnterProductQuantityAndAddToTheCart
		$I->fillField("#qty", "1"); // stepKey: fillTheProductQuantityEnterProductQuantityAndAddToTheCart
		$I->click("#product-addtocart-button"); // stepKey: clickOnAddToButtonEnterProductQuantityAndAddToTheCart
		$I->waitForPageLoad(30); // stepKey: clickOnAddToButtonEnterProductQuantityAndAddToTheCartWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadEnterProductQuantityAndAddToTheCart
		$I->waitForElementVisible("div.message-success.success.message", 30); // stepKey: waitForSuccessMessageEnterProductQuantityAndAddToTheCart
		$I->comment("Exiting Action Group [enterProductQuantityAndAddToTheCart] StorefrontEnterProductQuantityAndAddToTheCartActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollToTop
		$I->waitForPageLoad(30); // stepKey: waitForMiniCartPanelToAppear
		$I->comment("Assert Product in Mini Cart");
		$I->comment("Entering Action Group [clickOnMiniCart] StorefrontClickOnMiniCartActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollToTheTopOfThePageClickOnMiniCart
		$I->waitForElementVisible("a.showcart", 30); // stepKey: waitForElementToBeVisibleClickOnMiniCart
		$I->waitForPageLoad(60); // stepKey: waitForElementToBeVisibleClickOnMiniCartWaitForPageLoad
		$I->click("a.showcart"); // stepKey: clickOnMiniCartClickOnMiniCart
		$I->waitForPageLoad(60); // stepKey: clickOnMiniCartClickOnMiniCartWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadClickOnMiniCart
		$I->comment("Exiting Action Group [clickOnMiniCart] StorefrontClickOnMiniCartActionGroup");
		$I->comment("Entering Action Group [assertSimpleProduct3MiniCart] AssertStorefrontMiniCartItemsActionGroup");
		$I->see("$10.00", ".minicart-items"); // stepKey: seeProductPriceInMiniCartAssertSimpleProduct3MiniCart
		$I->seeElement("#top-cart-btn-checkout"); // stepKey: seeCheckOutButtonInMiniCartAssertSimpleProduct3MiniCart
		$I->waitForPageLoad(30); // stepKey: seeCheckOutButtonInMiniCartAssertSimpleProduct3MiniCartWaitForPageLoad
		$I->seeElement("//*[@id='mini-cart']//a[contains(text(),'" . $I->retrieveEntityField('createBundleProduct', 'name', 'test') . "')]/../..//div[@class='details-qty qty']//input[@data-item-qty='1']"); // stepKey: seeProductQuantity1AssertSimpleProduct3MiniCart
		$I->seeElement("//ol[@id='mini-cart']//img[@class='product-image-photo']"); // stepKey: seeProductImageAssertSimpleProduct3MiniCart
		$I->see("$10.00", "//div[@class='subtotal']//span/span[@class='price']"); // stepKey: seeSubTotalAssertSimpleProduct3MiniCart
		$I->see($I->retrieveEntityField('createBundleProduct', 'name', 'test'), ".minicart-items"); // stepKey: seeProductNameInMiniCartAssertSimpleProduct3MiniCart
		$I->comment("Exiting Action Group [assertSimpleProduct3MiniCart] AssertStorefrontMiniCartItemsActionGroup");
		$I->comment("Select Mini Cart and select 'View And Edit Cart'");
		$I->comment("Entering Action Group [seeProductInMiniCart] AssertOneProductNameInMiniCartActionGroup");
		$I->conditionalClick("a.showcart", "a.showcart.active", false); // stepKey: openMiniCartSeeProductInMiniCart
		$I->waitForElementVisible(".action.viewcart", 30); // stepKey: waitForViewAndEditCartVisibleSeeProductInMiniCart
		$I->waitForPageLoad(30); // stepKey: waitForViewAndEditCartVisibleSeeProductInMiniCartWaitForPageLoad
		$I->see($I->retrieveEntityField('createBundleProduct', 'name', 'test'), ".minicart-items"); // stepKey: seeInMiniCartSeeProductInMiniCart
		$I->comment("Exiting Action Group [seeProductInMiniCart] AssertOneProductNameInMiniCartActionGroup");
		$I->comment("Remove an item from the cart using minicart");
		$I->comment("Entering Action Group [removeProductFromMiniCart] RemoveProductFromMiniCartActionGroup");
		$I->conditionalClick("a.showcart", "a.showcart.active", false); // stepKey: openMiniCartRemoveProductFromMiniCart
		$I->waitForElementVisible(".action.viewcart", 30); // stepKey: waitForMiniCartOpenRemoveProductFromMiniCart
		$I->waitForPageLoad(30); // stepKey: waitForMiniCartOpenRemoveProductFromMiniCartWaitForPageLoad
		$I->click("//ol[@id='mini-cart']//div[contains(., '" . $I->retrieveEntityField('createBundleProduct', 'name', 'test') . "')]//a[contains(@class, 'delete')]"); // stepKey: clickDeleteRemoveProductFromMiniCart
		$I->waitForElementVisible("aside.confirm div.modal-content", 30); // stepKey: waitForConfirmationModalRemoveProductFromMiniCart
		$I->see("Are you sure you would like to remove this item from the shopping cart?", "aside.confirm div.modal-content"); // stepKey: seeDeleteConfirmationMessageRemoveProductFromMiniCart
		$I->click("aside.confirm .modal-footer .action-primary"); // stepKey: confirmDeleteRemoveProductFromMiniCart
		$I->waitForPageLoad(30); // stepKey: waitForDeleteToFinishRemoveProductFromMiniCart
		$I->comment("Exiting Action Group [removeProductFromMiniCart] RemoveProductFromMiniCartActionGroup");
		$I->reloadPage(); // stepKey: reloadPage
		$I->comment("Check the minicart is empty and verify AssertProductAbsentInMiniShoppingCart");
		$I->comment("Entering Action Group [miniCartEnpty] AssertMiniCartEmptyActionGroup");
		$I->dontSeeElement("//header//div[contains(@class, 'minicart-wrapper')]//a[contains(@class, 'showcart')]//span[@class='counter-number']"); // stepKey: dontSeeMinicartProductCountMiniCartEnpty
		$I->click("a.showcart"); // stepKey: expandMinicartMiniCartEnpty
		$I->waitForPageLoad(60); // stepKey: expandMinicartMiniCartEnptyWaitForPageLoad
		$I->see("You have no items in your shopping cart.", "#minicart-content-wrapper"); // stepKey: seeEmptyCartMessageMiniCartEnpty
		$I->comment("Exiting Action Group [miniCartEnpty] AssertMiniCartEmptyActionGroup");
		$I->dontSee("//header//ol[@id='mini-cart']//div[@class='product-item-details']//a[contains(text(), '" . $I->retrieveEntityField('createBundleProduct', 'name', 'test') . "')]"); // stepKey: verifyAssertProductAbsentInMiniShoppingCart
	}
}
