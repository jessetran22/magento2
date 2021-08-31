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
 * @Title("MC-41596: Minimum Advertised Price 'What's this?' popup does not displays in cart")
 * @Description("When Minimum Advertised Price (MAP) is enabled and the product has MAP set in Advanced Pricing, click on 'What's this?' at the product listing in the shopping cart must display the popup with the info message.<h3>Test files</h3>app/code/Magento/Checkout/Test/Mftf/Test/StorefrontVerifyMapMessagePopupOnCartViewPageTest.xml<br>")
 * @TestCaseId("MC-41596")
 * @group shoppingCart
 * @group checkout
 */
class StorefrontVerifyMapMessagePopupOnCartViewPageTestCest
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
		$I->comment("Enable MAP functionality in Magento Instance");
		$I->createEntity("enableMAP", "hook", "MsrpEnableMAP", [], []); // stepKey: enableMAP
		$I->comment("Create product and category");
		$I->createEntity("category", "hook", "_defaultCategory", [], []); // stepKey: category
		$I->createEntity("product", "hook", "SimpleProduct", ["category"], []); // stepKey: product
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Disable MAP functionality in Magento Instance");
		$I->createEntity("disableMAP", "hook", "MsrpDisableMAP", [], []); // stepKey: disableMAP
		$I->comment("Delete product and category");
		$I->deleteEntity("product", "hook"); // stepKey: deleteSimpleProduct
		$I->deleteEntity("category", "hook"); // stepKey: deleteCategory
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
	 * @Features({"Checkout"})
	 * @Severity(level = SeverityLevel::NORMAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function StorefrontVerifyMapMessagePopupOnCartViewPageTest(AcceptanceTester $I)
	{
		$I->comment("Add MAP to the newly created product Advanced Pricing");
		$I->comment("Entering Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsAdmin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginAsAdmin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginAsAdmin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsAdmin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsAdminWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsAdmin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsAdmin
		$I->comment("Exiting Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->comment("Entering Action Group [openAdminProductEditPage] AdminProductPageOpenByIdActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/edit/id/" . $I->retrieveEntityField('product', 'id', 'test')); // stepKey: goToProductOpenAdminProductEditPage
		$I->comment("Exiting Action Group [openAdminProductEditPage] AdminProductPageOpenByIdActionGroup");
		$I->comment("Entering Action Group [setMapToCreatedProduct] AdminAddMinimumAdvertisedPriceActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadSetMapToCreatedProduct
		$I->click("button[data-index='advanced_pricing_button']"); // stepKey: clickAdvancedPricingLinkSetMapToCreatedProduct
		$I->waitForPageLoad(30); // stepKey: clickAdvancedPricingLinkSetMapToCreatedProductWaitForPageLoad
		$I->waitForElementVisible("//input[@name='product[msrp]']", 30); // stepKey: waitSpecialPriceSetMapToCreatedProduct
		$I->waitForPageLoad(30); // stepKey: waitSpecialPriceSetMapToCreatedProductWaitForPageLoad
		$I->fillField("//input[@name='product[msrp]']", "600"); // stepKey: fillMinimumAdvertisedPriceSetMapToCreatedProduct
		$I->waitForPageLoad(30); // stepKey: fillMinimumAdvertisedPriceSetMapToCreatedProductWaitForPageLoad
		$I->selectOption("//select[@name='product[msrp_display_actual_price_type]']", "Before Order Confirmation"); // stepKey: selectPriceTypeSetMapToCreatedProduct
		$I->waitForPageLoad(30); // stepKey: selectPriceTypeSetMapToCreatedProductWaitForPageLoad
		$I->click(".product_form_product_form_advanced_pricing_modal button.action-primary"); // stepKey: clickDoneSetMapToCreatedProduct
		$I->waitForPageLoad(30); // stepKey: clickDoneSetMapToCreatedProductWaitForPageLoad
		$I->waitForElementNotVisible("//input[@name='product[msrp]']", 30); // stepKey: waitForCloseModalWindowSetMapToCreatedProduct
		$I->waitForPageLoad(30); // stepKey: waitForCloseModalWindowSetMapToCreatedProductWaitForPageLoad
		$I->comment("Exiting Action Group [setMapToCreatedProduct] AdminAddMinimumAdvertisedPriceActionGroup");
		$I->comment("Entering Action Group [saveProductForm] SaveProductFormActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollTopPageProductSaveProductForm
		$I->waitForElementVisible("#save-button", 30); // stepKey: waitForSaveProductButtonSaveProductForm
		$I->waitForPageLoad(30); // stepKey: waitForSaveProductButtonSaveProductFormWaitForPageLoad
		$I->click("#save-button"); // stepKey: clickSaveProductSaveProductForm
		$I->waitForPageLoad(30); // stepKey: clickSaveProductSaveProductFormWaitForPageLoad
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitProductSaveSuccessMessageSaveProductForm
		$I->dontSee(".message-warning"); // stepKey: dontSeeWarningMessageSaveProductForm
		$I->see("You saved the product.", "#messages div.message-success"); // stepKey: seeSaveConfirmationSaveProductForm
		$I->comment("Exiting Action Group [saveProductForm] SaveProductFormActionGroup");
		$I->comment("Entering Action Group [logoutAdmin] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageLogoutAdmin
		$I->comment("Exiting Action Group [logoutAdmin] AdminLogoutActionGroup");
		$I->comment("Adding the newly created product to shopping cart.");
		$I->comment("Entering Action Group [goToCategoryPageOnFrontEnd] StorefrontNavigateToCategoryUrlActionGroup");
		$I->amOnPage("/" . $I->retrieveEntityField('category', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: goToStorefrontCategoryPageGoToCategoryPageOnFrontEnd
		$I->comment("Exiting Action Group [goToCategoryPageOnFrontEnd] StorefrontNavigateToCategoryUrlActionGroup");
		$I->comment("Entering Action Group [addProductToCart] StorefrontAddSimpleProductToCartActionGroup");
		$I->moveMouseOver("//main//li[.//a[contains(text(), '" . $I->retrieveEntityField('product', 'name', 'test') . "')]]//div[@class='product-item-info']"); // stepKey: moveMouseOverProductAddProductToCart
		$I->click("//main//li[.//a[contains(text(), '" . $I->retrieveEntityField('product', 'name', 'test') . "')]]//button[contains(@class, 'tocart')]"); // stepKey: clickAddToCartAddProductToCart
		$I->waitForElementVisible("div.message-success", 30); // stepKey: waitForSuccessMessageAddProductToCart
		$I->see("You added " . $I->retrieveEntityField('product', 'name', 'test') . " to your shopping cart.", "div.message-success"); // stepKey: assertSuccessMessageAddProductToCart
		$I->comment("Exiting Action Group [addProductToCart] StorefrontAddSimpleProductToCartActionGroup");
		$I->comment("Navigate to the cart edit page");
		$I->comment("Entering Action Group [goToCartViewAndEditPage] clickViewAndEditCartFromMiniCartActionGroup");
		$I->scrollTo("a.showcart"); // stepKey: scrollToMiniCartGoToCartViewAndEditPage
		$I->waitForPageLoad(60); // stepKey: scrollToMiniCartGoToCartViewAndEditPageWaitForPageLoad
		$I->conditionalClick("a.showcart", "a.showcart.active", false); // stepKey: openMiniCartGoToCartViewAndEditPage
		$I->waitForElementVisible(".action.viewcart", 30); // stepKey: waitForViewAndEditCartVisibleGoToCartViewAndEditPage
		$I->waitForPageLoad(30); // stepKey: waitForViewAndEditCartVisibleGoToCartViewAndEditPageWaitForPageLoad
		$I->click(".action.viewcart"); // stepKey: viewAndEditCartGoToCartViewAndEditPage
		$I->waitForPageLoad(30); // stepKey: viewAndEditCartGoToCartViewAndEditPageWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadGoToCartViewAndEditPage
		$I->seeInCurrentUrl("checkout/cart"); // stepKey: seeInCurrentUrlGoToCartViewAndEditPage
		$I->comment("Exiting Action Group [goToCartViewAndEditPage] clickViewAndEditCartFromMiniCartActionGroup");
		$I->comment("Check if MAP message and link are present and functioning");
		$I->comment("Entering Action Group [checkFormMapFunctioning] StorefrontCartPageCheckMapMessagePresentAndClickableActionGroup");
		$I->comment("Confirm that the MAP message and help link are visible");
		$I->see("See price before order confirmation.", ".msrp.notice"); // stepKey: seeMsrpNoticeCheckFormMapFunctioning
		$I->see("What's this?", ".msrp .action.help.map"); // stepKey: seeMsrpNoticeHelpLinkCheckFormMapFunctioning
		$I->comment("Confirm that clicking on the 'What's this?' link shows the help popup");
		$I->click(".msrp .action.help.map"); // stepKey: clickOnWhatsThisLinkCheckFormMapFunctioning
		$I->waitForElementVisible("//div[@id='map-popup-text-what-this']", 30); // stepKey: waitForTheInfoMessageCheckFormMapFunctioning
		$I->comment("Confirm that clicking on X button closes the popup");
		$I->click(".popup button.action.close"); // stepKey: clickOnCloseInfoMessageCheckFormMapFunctioning
		$I->waitForElementNotVisible("//div[@id='map-popup-text-what-this']", 30); // stepKey: waitForTheInfoMessageToCloseCheckFormMapFunctioning
		$I->comment("Exiting Action Group [checkFormMapFunctioning] StorefrontCartPageCheckMapMessagePresentAndClickableActionGroup");
	}
}
