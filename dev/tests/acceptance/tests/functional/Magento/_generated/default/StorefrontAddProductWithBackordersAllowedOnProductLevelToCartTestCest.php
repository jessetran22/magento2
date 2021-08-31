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
 * @Title("[NO TESTCASEID]: Add Product to Cart, Backorders Allowed On Product Level")
 * @Description("Customer should be able to add products to Cart if product qty less or equal 0 and Backorders are allowed on Product level<h3>Test files</h3>app/code/Magento/Catalog/Test/Mftf/Test/StorefrontAddProductWithBackordersAllowedOnProductLevelToCartTest.xml<br>")
 * @group catalog
 */
class StorefrontAddProductWithBackordersAllowedOnProductLevelToCartTestCest
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
    }
	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _before(AcceptanceTester $I)
	{
		$I->createEntity("createProduct", "hook", "SimpleProductInStockQuantityZero", [], []); // stepKey: createProduct
		$I->comment("Entering Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsAdmin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginAsAdmin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginAsAdmin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsAdmin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsAdminWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsAdmin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsAdmin
		$I->comment("Exiting Action Group [loginAsAdmin] AdminLoginActionGroup");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [logout] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageLogout
		$I->comment("Exiting Action Group [logout] AdminLogoutActionGroup");
		$I->deleteEntity("createProduct", "hook"); // stepKey: deleteProduct
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
	 * @Features({"Catalog"})
	 * @Stories({"Manage inventory, backorders"})
	 * @Severity(level = SeverityLevel::NORMAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function StorefrontAddProductWithBackordersAllowedOnProductLevelToCartTest(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [openCreatedProductEditPage] NavigateToCreatedProductEditPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: goToAdminProductIndexPageOpenCreatedProductEditPage
		$I->waitForPageLoad(30); // stepKey: waitForProductIndexPageToLoadOpenCreatedProductEditPage
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersOpenCreatedProductEditPage
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersOpenCreatedProductEditPageWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForClearFiltersOpenCreatedProductEditPage
		$I->dontSeeElement(".admin__data-grid-header button[data-action='grid-filter-reset']"); // stepKey: dontSeeClearFiltersOpenCreatedProductEditPage
		$I->waitForPageLoad(30); // stepKey: dontSeeClearFiltersOpenCreatedProductEditPageWaitForPageLoad
		$I->click(".admin__data-grid-action-bookmarks button.admin__action-dropdown"); // stepKey: openViewBookmarksTabOpenCreatedProductEditPage
		$I->click("//div[contains(@class, 'admin__data-grid-action-bookmarks')]/ul/li/div/a[text() = 'Default View']"); // stepKey: resetToDefaultGridViewOpenCreatedProductEditPage
		$I->waitForPageLoad(30); // stepKey: resetToDefaultGridViewOpenCreatedProductEditPageWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForResetToDefaultViewOpenCreatedProductEditPage
		$I->see("Default View", ".admin__data-grid-action-bookmarks button.admin__action-dropdown"); // stepKey: seeDefaultViewSelectedOpenCreatedProductEditPage
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openProductFiltersOpenCreatedProductEditPage
		$I->fillField("input.admin__control-text[name='sku']", $I->retrieveEntityField('createProduct', 'sku', 'test')); // stepKey: fillProductSkuFilterOpenCreatedProductEditPage
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersOpenCreatedProductEditPage
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersOpenCreatedProductEditPageWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForFilterOnGridOpenCreatedProductEditPage
		$I->click("//td/div[text()='" . $I->retrieveEntityField('createProduct', 'name', 'test') . "']"); // stepKey: clickProductOpenCreatedProductEditPage
		$I->waitForPageLoad(30); // stepKey: waitForProductEditPageLoadOpenCreatedProductEditPage
		$I->waitForElementVisible("//*[@name='product[sku]']", 30); // stepKey: waitForProductSKUFieldOpenCreatedProductEditPage
		$I->seeInField("//*[@name='product[sku]']", $I->retrieveEntityField('createProduct', 'sku', 'test')); // stepKey: seeProductSKUOpenCreatedProductEditPage
		$I->comment("Exiting Action Group [openCreatedProductEditPage] NavigateToCreatedProductEditPageActionGroup");
		$I->comment("Entering Action Group [clickOnAdvancedInventoryLink] AdminClickOnAdvancedInventoryLinkActionGroup");
		$I->click("button[data-index='advanced_inventory_button'].action-additional"); // stepKey: clickOnAdvancedInventoryLinkClickOnAdvancedInventoryLink
		$I->waitForPageLoad(30); // stepKey: clickOnAdvancedInventoryLinkClickOnAdvancedInventoryLinkWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForAdvancedInventoryPageToLoadClickOnAdvancedInventoryLink
		$I->comment("Wait for close button appeared. That means animation finished and modal window is fully visible");
		$I->waitForElementVisible(".product_form_product_form_advanced_inventory_modal button.action-close", 30); // stepKey: waitForCloseButtonAppearedClickOnAdvancedInventoryLink
		$I->waitForPageLoad(30); // stepKey: waitForCloseButtonAppearedClickOnAdvancedInventoryLinkWaitForPageLoad
		$I->comment("Exiting Action Group [clickOnAdvancedInventoryLink] AdminClickOnAdvancedInventoryLinkActionGroup");
		$I->comment("Entering Action Group [allowBackorders] AdminSetBackordersOnProductAdvancedInventoryActionGroup");
		$I->uncheckOption("//input[@name='product[stock_data][use_config_backorders]']"); // stepKey: uncheckUseConfigSettingsAllowBackorders
		$I->selectOption("//*[@name='product[stock_data][backorders]']", "Allow Qty Below 0"); // stepKey: fillBackordersAllowBackorders
		$I->comment("Exiting Action Group [allowBackorders] AdminSetBackordersOnProductAdvancedInventoryActionGroup");
		$I->comment("Entering Action Group [fillProductQty] AdminFillAdvancedInventoryQtyActionGroup");
		$I->fillField("//div[@class='modal-inner-wrap']//input[@name='product[quantity_and_stock_status][qty]']", "-5"); // stepKey: fillQtyFillProductQty
		$I->comment("Exiting Action Group [fillProductQty] AdminFillAdvancedInventoryQtyActionGroup");
		$I->comment("Entering Action Group [clickDoneButton] AdminSubmitAdvancedInventoryFormActionGroup");
		$I->click("//aside[contains(@class,'product_form_product_form_advanced_inventory_modal')]//button[contains(@data-role,'action')]"); // stepKey: clickOnDoneButtonClickDoneButton
		$I->waitForPageLoad(5); // stepKey: clickOnDoneButtonClickDoneButtonWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForProductPageToLoadClickDoneButton
		$I->comment("Exiting Action Group [clickDoneButton] AdminSubmitAdvancedInventoryFormActionGroup");
		$I->comment("Entering Action Group [saveProduct] SaveProductFormActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollTopPageProductSaveProduct
		$I->waitForElementVisible("#save-button", 30); // stepKey: waitForSaveProductButtonSaveProduct
		$I->waitForPageLoad(30); // stepKey: waitForSaveProductButtonSaveProductWaitForPageLoad
		$I->click("#save-button"); // stepKey: clickSaveProductSaveProduct
		$I->waitForPageLoad(30); // stepKey: clickSaveProductSaveProductWaitForPageLoad
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitProductSaveSuccessMessageSaveProduct
		$I->dontSee(".message-warning"); // stepKey: dontSeeWarningMessageSaveProduct
		$I->see("You saved the product.", "#messages div.message-success"); // stepKey: seeSaveConfirmationSaveProduct
		$I->comment("Exiting Action Group [saveProduct] SaveProductFormActionGroup");
		$I->comment("Entering Action Group [gotoAndAddProductToCart] AddSimpleProductToCartActionGroup");
		$I->amOnPage("/" . $I->retrieveEntityField('createProduct', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: goToProductPageGotoAndAddProductToCart
		$I->waitForPageLoad(30); // stepKey: waitForProductPageGotoAndAddProductToCart
		$I->click("button.action.tocart.primary"); // stepKey: addToCartGotoAndAddProductToCart
		$I->waitForPageLoad(30); // stepKey: addToCartGotoAndAddProductToCartWaitForPageLoad
		$I->waitForElementNotVisible("//button/span[text()='Adding...']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddingGotoAndAddProductToCart
		$I->waitForElementNotVisible("//button/span[text()='Added']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddedGotoAndAddProductToCart
		$I->waitForElementVisible("//button/span[text()='Add to Cart']", 30); // stepKey: waitForElementVisibleAddToCartButtonTitleIsAddToCartGotoAndAddProductToCart
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadGotoAndAddProductToCart
		$I->waitForElementVisible("div.message-success.success.message", 30); // stepKey: waitForProductAddedMessageGotoAndAddProductToCart
		$I->see("You added " . $I->retrieveEntityField('createProduct', 'name', 'test') . " to your shopping cart.", "div.message-success.success.message"); // stepKey: seeAddToCartSuccessMessageGotoAndAddProductToCart
		$I->comment("Exiting Action Group [gotoAndAddProductToCart] AddSimpleProductToCartActionGroup");
		$I->comment("Entering Action Group [gotoCart] StorefrontCartPageOpenActionGroup");
		$I->amOnPage("/checkout/cart"); // stepKey: openCartPageGotoCart
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadedGotoCart
		$I->comment("Exiting Action Group [gotoCart] StorefrontCartPageOpenActionGroup");
		$I->comment("Entering Action Group [assertProductItemInCheckOutCart] AssertStorefrontCheckoutCartItemsActionGroup");
		$I->waitForElementVisible("//tbody[@class='cart item']//strong[@class='product-item-name']", 60); // stepKey: waitForProductNameVisibleAssertProductItemInCheckOutCart
		$I->see($I->retrieveEntityField('createProduct', 'name', 'test'), "//tbody[@class='cart item']//strong[@class='product-item-name']"); // stepKey: seeProductNameInCheckoutSummaryAssertProductItemInCheckOutCart
		$I->see($I->retrieveEntityField('createProduct', 'price', 'test'), "//main//table[@id='shopping-cart-table']//tbody//tr[..//strong[contains(@class, 'product-item-name')]//a/text()='" . $I->retrieveEntityField('createProduct', 'name', 'test') . "'][1]//td[contains(@class, 'price')]//span[@class='price']"); // stepKey: seeProductPriceInCartAssertProductItemInCheckOutCart
		$I->see($I->retrieveEntityField('createProduct', 'price', 'test'), "//main//table[@id='shopping-cart-table']//tbody//tr[..//strong[contains(@class, 'product-item-name')]//a/text()='" . $I->retrieveEntityField('createProduct', 'name', 'test') . "'][1]//td[contains(@class, 'subtotal')]//span[@class='price']"); // stepKey: seeSubtotalPriceAssertProductItemInCheckOutCart
		$I->seeInField("//main//table[@id='shopping-cart-table']//tbody//tr[..//strong[contains(@class, 'product-item-name')]//a/text()='" . $I->retrieveEntityField('createProduct', 'name', 'test') . "'][1]//td[contains(@class, 'qty')]//input[contains(@class, 'qty')]", "1"); // stepKey: seeProductQuantityAssertProductItemInCheckOutCart
		$I->comment("Exiting Action Group [assertProductItemInCheckOutCart] AssertStorefrontCheckoutCartItemsActionGroup");
	}
}
