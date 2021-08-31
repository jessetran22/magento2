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
 * @Title("MC-11065: Add In Stock Product to Cart")
 * @Description("Login as admin and add In Stock product to the cart<h3>Test files</h3>app/code/Magento/Catalog/Test/Mftf/Test/AdminAddInStockProductToTheCartTest.xml<br>")
 * @TestCaseId("MC-11065")
 * @group mtf_migrated
 */
class AdminAddInStockProductToTheCartTestCest
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
		$I->comment("Login as admin");
		$I->comment("Entering Action Group [login] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLogin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLogin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLogin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLogin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLogin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLogin
		$I->comment("Exiting Action Group [login] AdminLoginActionGroup");
		$I->comment("Create Category");
		$I->createEntity("createCategory", "hook", "SimpleSubCategory", [], []); // stepKey: createCategory
		$I->comment("Create Simple Product");
		$I->createEntity("createSimpleProduct", "hook", "SimpleProduct", ["createCategory"], []); // stepKey: createSimpleProduct
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Delete created entity");
		$I->deleteEntity("createCategory", "hook"); // stepKey: deleteCategory
		$I->deleteEntity("createSimpleProduct", "hook"); // stepKey: deleteSimpleProduct
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
	 * @Stories({"Manage products"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Features({"Catalog"})
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminAddInStockProductToTheCartTest(AcceptanceTester $I)
	{
		$I->comment("Open Product Index Page and filter the product");
		$I->comment("Entering Action Group [navigateToProductIndex] AdminOpenProductIndexPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: goToProductIndexPageNavigateToProductIndex
		$I->waitForPageLoad(30); // stepKey: waitForProductIndexPageLoadNavigateToProductIndex
		$I->comment("Exiting Action Group [navigateToProductIndex] AdminOpenProductIndexPageActionGroup");
		$I->comment("Entering Action Group [filterProduct] FilterProductGridBySkuActionGroup");
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersFilterProduct
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersFilterProductWaitForPageLoad
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openProductFiltersFilterProduct
		$I->fillField("input.admin__control-text[name='sku']", "SimpleProduct" . msq("SimpleProduct")); // stepKey: fillProductSkuFilterFilterProduct
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersFilterProduct
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersFilterProductWaitForPageLoad
		$I->waitForElementNotVisible(".admin__data-grid-loading-mask[data-component*='product_listing']", 30); // stepKey: waitForFilteredGridLoadFilterProduct
		$I->comment("Exiting Action Group [filterProduct] FilterProductGridBySkuActionGroup");
		$I->comment("Update product Advanced Inventory setting");
		$I->click("//td[count(../../..//th[./*[.='SKU']]/preceding-sibling::th) + 1][./*[.='" . $I->retrieveEntityField('createSimpleProduct', 'sku', 'test') . "']]"); // stepKey: openSelectedProduct
		$I->waitForPageLoad(30); // stepKey: waitForProductToLoad
		$I->comment("Entering Action Group [clickOnAdvancedInventoryLink] AdminClickOnAdvancedInventoryLinkActionGroup");
		$I->click("button[data-index='advanced_inventory_button'].action-additional"); // stepKey: clickOnAdvancedInventoryLinkClickOnAdvancedInventoryLink
		$I->waitForPageLoad(30); // stepKey: clickOnAdvancedInventoryLinkClickOnAdvancedInventoryLinkWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForAdvancedInventoryPageToLoadClickOnAdvancedInventoryLink
		$I->comment("Wait for close button appeared. That means animation finished and modal window is fully visible");
		$I->waitForElementVisible(".product_form_product_form_advanced_inventory_modal button.action-close", 30); // stepKey: waitForCloseButtonAppearedClickOnAdvancedInventoryLink
		$I->waitForPageLoad(30); // stepKey: waitForCloseButtonAppearedClickOnAdvancedInventoryLinkWaitForPageLoad
		$I->comment("Exiting Action Group [clickOnAdvancedInventoryLink] AdminClickOnAdvancedInventoryLinkActionGroup");
		$I->uncheckOption("//input[@name='product[stock_data][use_config_manage_stock]']"); // stepKey: uncheckConfigSetting
		$I->selectOption("//*[@name='product[stock_data][manage_stock]']", "Yes"); // stepKey: clickOnManageStock
		$I->waitForPageLoad(30); // stepKey: clickOnManageStockWaitForPageLoad
		$I->fillField("//div[@class='modal-inner-wrap']//input[@name='product[quantity_and_stock_status][qty]']", "5"); // stepKey: fillProductQty
		$I->uncheckOption("//*[@name='product[stock_data][use_config_min_sale_qty]']"); // stepKey: uncheckMiniQtyCheckBox
		$I->fillField("//*[@name='product[stock_data][min_sale_qty]']", "1"); // stepKey: fillMiniAllowedQty
		$I->uncheckOption("//*[@name='product[stock_data][use_config_max_sale_qty]']"); // stepKey: uncheckMaxQtyCheckBox
		$I->fillField("//*[@name='product[stock_data][max_sale_qty]']", "10000"); // stepKey: fillMaxAllowedQty
		$I->selectOption("//*[@name='product[stock_data][is_qty_decimal]']", "Yes"); // stepKey: selectQuatityUsesDecimal
		$I->uncheckOption("//*[@name='product[stock_data][use_config_notify_stock_qty]']"); // stepKey: uncheckNotifyBelowQtyheckBox
		$I->fillField("//*[@name='product[stock_data][notify_stock_qty]']", "1"); // stepKey: fillNotifyBelowQty
		$I->comment("Entering Action Group [selectOutOfStock] AdminSetStockStatusConfigActionGroup");
		$I->selectOption("//div[@class='modal-inner-wrap']//select[@name='product[quantity_and_stock_status][is_in_stock]']", "In Stock"); // stepKey: selectStockStatusSelectOutOfStock
		$I->comment("Exiting Action Group [selectOutOfStock] AdminSetStockStatusConfigActionGroup");
		$I->comment("Entering Action Group [clickOnDoneButton] AdminSubmitAdvancedInventoryFormActionGroup");
		$I->click("//aside[contains(@class,'product_form_product_form_advanced_inventory_modal')]//button[contains(@data-role,'action')]"); // stepKey: clickOnDoneButtonClickOnDoneButton
		$I->waitForPageLoad(5); // stepKey: clickOnDoneButtonClickOnDoneButtonWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForProductPageToLoadClickOnDoneButton
		$I->comment("Exiting Action Group [clickOnDoneButton] AdminSubmitAdvancedInventoryFormActionGroup");
		$I->comment("Entering Action Group [clickOnSaveButton] AdminProductFormSaveActionGroup");
		$I->click("#save-button"); // stepKey: saveProductClickOnSaveButton
		$I->waitForPageLoad(30); // stepKey: saveProductClickOnSaveButtonWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForProductSavingClickOnSaveButton
		$I->comment("Exiting Action Group [clickOnSaveButton] AdminProductFormSaveActionGroup");
		$I->see("You saved the product.", ".message-success"); // stepKey: messageYouSavedTheProductIsShown
		$I->comment("Adding the comment to replace CliIndexerReindexActionGroup action group ('indexer:reindex' commands) for preserving Backward Compatibility");
		$I->comment("Adding the comment to replace CliCacheFlushActionGroup action group ('cache:flush' command) for preserving Backward Compatibility");
		$I->comment("Verify product is visible in category front page");
		$I->amOnPage($I->retrieveEntityField('createCategory', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: openCategoryStoreFrontPage
		$I->waitForPageLoad(30); // stepKey: waitForCategoryPageToLoad
		$I->seeElement("//nav//a[span[contains(., 'SimpleSubCategory" . msq("SimpleSubCategory") . "')]]"); // stepKey: seeCategoryInFrontPage
		$I->waitForPageLoad(30); // stepKey: seeCategoryInFrontPageWaitForPageLoad
		$I->click("//nav//a[span[contains(., 'SimpleSubCategory" . msq("SimpleSubCategory") . "')]]"); // stepKey: clickOnCategory
		$I->waitForPageLoad(30); // stepKey: clickOnCategoryWaitForPageLoad
		$I->see("Simple Product " . msq("SimpleProduct"), ".product-item-name"); // stepKey: seeProductNameInCategoryPage
		$I->comment("Verify Product In Store Front");
		$I->amOnPage($I->retrieveEntityField('createSimpleProduct', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: goToStorefrontPage
		$I->waitForPageLoad(30); // stepKey: waitForProductFrontPageToLoad
		$I->see("Simple Product " . msq("SimpleProduct"), ".base"); // stepKey: seeProductNameInStoreFront
		$I->see("123.00", "div.price-box.price-final_price"); // stepKey: seeProductPriceInStoreFront
		$I->comment("Entering Action Group [seeProductSkuInStoreFront] StorefrontAssertProductSkuOnProductPageActionGroup");
		$I->see("SimpleProduct" . msq("SimpleProduct"), ".product.attribute.sku>.value"); // stepKey: seeProductSkuSeeProductSkuInStoreFront
		$I->comment("Exiting Action Group [seeProductSkuInStoreFront] StorefrontAssertProductSkuOnProductPageActionGroup");
		$I->see("In Stock", ".stock[title=Availability]>span"); // stepKey: seeProductStatusInStoreFront
		$I->comment("Add Product to the cart");
		$I->fillField("input.input-text.qty", "1"); // stepKey: fillProductQuantity
		$I->waitForPageLoad(30); // stepKey: fillProductQuantityWaitForPageLoad
		$I->comment("Entering Action Group [addToCartFromStorefrontProductPage] StorefrontClickAddToCartOnProductPageActionGroup");
		$I->click("#product-addtocart-button"); // stepKey: addToCartAddToCartFromStorefrontProductPage
		$I->waitForPageLoad(60); // stepKey: addToCartAddToCartFromStorefrontProductPageWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForAddToCartAddToCartFromStorefrontProductPage
		$I->waitForElementVisible("div.message-success.success.message", 30); // stepKey: waitForSuccessMessageAddToCartFromStorefrontProductPage
		$I->comment("Exiting Action Group [addToCartFromStorefrontProductPage] StorefrontClickAddToCartOnProductPageActionGroup");
		$I->seeElement("div.message-success"); // stepKey: seeSuccessSaveMessage
		$I->waitForPageLoad(30); // stepKey: seeSuccessSaveMessageWaitForPageLoad
		$I->seeElement("span.counter-number"); // stepKey: seeAddedProductQuantityInCart
		$I->comment("Entering Action Group [clickOnMiniCart] StorefrontClickOnMiniCartActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollToTheTopOfThePageClickOnMiniCart
		$I->waitForElementVisible("a.showcart", 30); // stepKey: waitForElementToBeVisibleClickOnMiniCart
		$I->waitForPageLoad(60); // stepKey: waitForElementToBeVisibleClickOnMiniCartWaitForPageLoad
		$I->click("a.showcart"); // stepKey: clickOnMiniCartClickOnMiniCart
		$I->waitForPageLoad(60); // stepKey: clickOnMiniCartClickOnMiniCartWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadClickOnMiniCart
		$I->comment("Exiting Action Group [clickOnMiniCart] StorefrontClickOnMiniCartActionGroup");
		$I->see("Simple Product " . msq("SimpleProduct"), ".minicart-items"); // stepKey: seeProductNameInMiniCart
		$I->see("123.00", ".minicart-items"); // stepKey: seeProductPriceInMiniCart
		$I->seeElement("#top-cart-btn-checkout"); // stepKey: seeCheckOutButtonInMiniCart
		$I->waitForPageLoad(30); // stepKey: seeCheckOutButtonInMiniCartWaitForPageLoad
	}
}
