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
 * @Title("MAGETWO-93973: Tiered pricing and quantity increments work with decimal inventory")
 * @Description("Tiered pricing and quantity increments work with decimal inventory<h3>Test files</h3>app/code/Magento/Catalog/Test/Mftf/Test/TieredPricingAndQuantityIncrementsWorkWithDecimalinventoryTest.xml<br>")
 * @TestCaseId("MAGETWO-93973")
 * @group Catalog
 */
class TieredPricingAndQuantityIncrementsWorkWithDecimalinventoryTestCest
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
		$I->createEntity("createPreReqCategory", "hook", "_defaultCategory", [], []); // stepKey: createPreReqCategory
		$I->createEntity("createPreReqSimpleProduct", "hook", "SimpleProduct", ["createPreReqCategory"], []); // stepKey: createPreReqSimpleProduct
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->deleteEntity("createPreReqCategory", "hook"); // stepKey: deletePreReqCategory
		$I->deleteEntity("createPreReqSimpleProduct", "hook"); // stepKey: deletePreReqSimpleProduct
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
	 * @Stories({"Tiered pricing and quantity increments work with decimal inventory"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function TieredPricingAndQuantityIncrementsWorkWithDecimalinventoryTest(AcceptanceTester $I)
	{
		$I->comment("Step1. Login as admin. Go to Catalog > Products page. Filtering *prod1*. Open *prod1* to edit");
		$I->comment("Entering Action Group [LoginAsAdmin] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsAdmin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginAsAdmin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginAsAdmin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsAdmin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsAdminWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsAdmin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsAdmin
		$I->comment("Exiting Action Group [LoginAsAdmin] AdminLoginActionGroup");
		$I->comment("Entering Action Group [filterGroupedProductOptions] SearchForProductOnBackendActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: navigateToProductIndexFilterGroupedProductOptions
		$I->waitForPageLoad(60); // stepKey: waitForProductsPageToLoadFilterGroupedProductOptions
		$I->click("#container > div > div.admin__data-grid-header > div:nth-child(1) > div.data-grid-filters-actions-wrap > div > button"); // stepKey: openFiltersSectionOnProductsPageFilterGroupedProductOptions
		$I->conditionalClick("//div[@class='admin__data-grid-header']//button[@class='action-tertiary action-clear']", "//div[@class='admin__data-grid-header']//button[@class='action-tertiary action-clear']", true); // stepKey: cleanFiltersIfTheySetFilterGroupedProductOptions
		$I->waitForPageLoad(10); // stepKey: cleanFiltersIfTheySetFilterGroupedProductOptionsWaitForPageLoad
		$I->fillField("input[name=sku]", "SimpleProduct" . msq("SimpleProduct")); // stepKey: fillSkuFieldOnFiltersSectionFilterGroupedProductOptions
		$I->click("button[data-action=grid-filter-apply]"); // stepKey: clickApplyFiltersButtonFilterGroupedProductOptions
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersButtonFilterGroupedProductOptionsWaitForPageLoad
		$I->comment("Exiting Action Group [filterGroupedProductOptions] SearchForProductOnBackendActionGroup");
		$I->click("//tbody//tr//td//div[contains(., '" . $I->retrieveEntityField('createPreReqSimpleProduct', 'name', 'test') . "')]"); // stepKey: clickOpenProductForEdit
		$I->waitForPageLoad(30); // stepKey: clickOpenProductForEditWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForProductEditOpen
		$I->comment("Step2. Open *Advanced Inventory* pop-up (Click on *Advanced Inventory* link). Set *Qty Uses Decimals* to *Yes*. Click on button *Done*");
		$I->comment("Entering Action Group [clickOnAdvancedInventoryLink] AdminClickOnAdvancedInventoryLinkActionGroup");
		$I->click("button[data-index='advanced_inventory_button'].action-additional"); // stepKey: clickOnAdvancedInventoryLinkClickOnAdvancedInventoryLink
		$I->waitForPageLoad(30); // stepKey: clickOnAdvancedInventoryLinkClickOnAdvancedInventoryLinkWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForAdvancedInventoryPageToLoadClickOnAdvancedInventoryLink
		$I->comment("Wait for close button appeared. That means animation finished and modal window is fully visible");
		$I->waitForElementVisible(".product_form_product_form_advanced_inventory_modal button.action-close", 30); // stepKey: waitForCloseButtonAppearedClickOnAdvancedInventoryLink
		$I->waitForPageLoad(30); // stepKey: waitForCloseButtonAppearedClickOnAdvancedInventoryLinkWaitForPageLoad
		$I->comment("Exiting Action Group [clickOnAdvancedInventoryLink] AdminClickOnAdvancedInventoryLinkActionGroup");
		$I->scrollTo("//*[@name='product[stock_data][is_qty_decimal]']"); // stepKey: scrollToQtyUsesDecimalsDropBox
		$I->click("//*[@name='product[stock_data][is_qty_decimal]']"); // stepKey: clickOnQtyUsesDecimalsDropBox
		$I->click("//*[@name='product[stock_data][is_qty_decimal]']//option[contains(@value, '1')]"); // stepKey: chooseYesOnQtyUsesDecimalsDropBox
		$I->comment("Entering Action Group [clickOnDoneButton] AdminSubmitAdvancedInventoryFormActionGroup");
		$I->click("//aside[contains(@class,'product_form_product_form_advanced_inventory_modal')]//button[contains(@data-role,'action')]"); // stepKey: clickOnDoneButtonClickOnDoneButton
		$I->waitForPageLoad(5); // stepKey: clickOnDoneButtonClickOnDoneButtonWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForProductPageToLoadClickOnDoneButton
		$I->comment("Exiting Action Group [clickOnDoneButton] AdminSubmitAdvancedInventoryFormActionGroup");
		$I->comment("Step3. Open *Advanced Pricing* pop-up (Click on *Advanced Pricing* link). Click on *Add* button. Fill *0.5* in *Quantity*");
		$I->scrollTo(".admin__field[data-index=name] input"); // stepKey: scrollToProductName
		$I->click("button[data-index='advanced_pricing_button']"); // stepKey: clickOnAdvancedPricingLink1
		$I->waitForPageLoad(30); // stepKey: clickOnAdvancedPricingLink1WaitForPageLoad
		$I->waitForElement("[data-action='add_new_row']", 30); // stepKey: waitForAddButton
		$I->waitForPageLoad(30); // stepKey: waitForAddButtonWaitForPageLoad
		$I->click("[data-action='add_new_row']"); // stepKey: clickOnCustomerGroupPriceAddButton
		$I->waitForPageLoad(30); // stepKey: clickOnCustomerGroupPriceAddButtonWaitForPageLoad
		$I->fillField("[name='product[tier_price][0][price_qty]']", "0.5"); // stepKey: fillProductTierPriceQty
		$I->comment("Step4. Close *Advanced Pricing* (Click on button *Done*). Save *prod1* (Click on button *Save*)");
		$I->click(".product_form_product_form_advanced_pricing_modal button.action-primary"); // stepKey: clickOnDoneButton2
		$I->waitForPageLoad(30); // stepKey: clickOnDoneButton2WaitForPageLoad
		$I->comment("Entering Action Group [clickOnSaveButton] AdminProductFormSaveActionGroup");
		$I->click("#save-button"); // stepKey: saveProductClickOnSaveButton
		$I->waitForPageLoad(30); // stepKey: saveProductClickOnSaveButtonWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForProductSavingClickOnSaveButton
		$I->comment("Exiting Action Group [clickOnSaveButton] AdminProductFormSaveActionGroup");
		$I->comment("The code should be uncommented after fix MAGETWO-96016");
		$I->comment("<click selector=\"\{\{AdminProductFormSection.advancedPricingLink\}\}\" stepKey=\"clickOnAdvancedPricingLink2\"/>");
		$I->comment("<seeInField userInput=\"0.5\" selector=\"\{\{AdminProductFormAdvancedPricingSection.productTierPriceQtyInput('0')\}\}\" stepKey=\"seeInField1\"/>");
		$I->comment("<click selector=\"\{\{AdminProductFormAdvancedPricingSection.advancedPricingCloseButton\}\}\" stepKey=\"clickOnCloseButton\"/>");
		$I->comment("Step5. Open *Advanced Inventory* pop-up. Set *Enable Qty Increments* to *Yes*. Fill *.5* in *Qty Increments*");
		$I->comment("Entering Action Group [clickOnAdvancedInventoryLink2] AdminClickOnAdvancedInventoryLinkActionGroup");
		$I->click("button[data-index='advanced_inventory_button'].action-additional"); // stepKey: clickOnAdvancedInventoryLinkClickOnAdvancedInventoryLink2
		$I->waitForPageLoad(30); // stepKey: clickOnAdvancedInventoryLinkClickOnAdvancedInventoryLink2WaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForAdvancedInventoryPageToLoadClickOnAdvancedInventoryLink2
		$I->comment("Wait for close button appeared. That means animation finished and modal window is fully visible");
		$I->waitForElementVisible(".product_form_product_form_advanced_inventory_modal button.action-close", 30); // stepKey: waitForCloseButtonAppearedClickOnAdvancedInventoryLink2
		$I->waitForPageLoad(30); // stepKey: waitForCloseButtonAppearedClickOnAdvancedInventoryLink2WaitForPageLoad
		$I->comment("Exiting Action Group [clickOnAdvancedInventoryLink2] AdminClickOnAdvancedInventoryLinkActionGroup");
		$I->scrollTo("//*[@name='product[stock_data][enable_qty_increments]']"); // stepKey: scrollToEnableQtyIncrements
		$I->click("//input[@name='product[stock_data][use_config_enable_qty_inc]']"); // stepKey: clickOnEnableQtyIncrementsUseConfigSettingsCheckbox
		$I->click("//*[@name='product[stock_data][enable_qty_increments]']"); // stepKey: clickOnEnableQtyIncrements
		$I->click("//*[@name='product[stock_data][enable_qty_increments]']//option[contains(@value, '1')]"); // stepKey: chooseYesOnEnableQtyIncrements
		$I->scrollTo("//input[@name='product[stock_data][use_config_qty_increments]']"); // stepKey: scrollToQtyIncrementsUseConfigSettings
		$I->click("//input[@name='product[stock_data][use_config_qty_increments]']"); // stepKey: clickOnQtyIncrementsUseConfigSettings
		$I->scrollTo("//input[@name='product[stock_data][qty_increments]']"); // stepKey: scrollToQtyIncrements
		$I->fillField("//input[@name='product[stock_data][qty_increments]']", ".5"); // stepKey: fillQtyIncrements
		$I->comment("Step6. Close *Advanced Inventory* (Click on button *Done*). Save *prod1* (Click on button *Save*)");
		$I->comment("Entering Action Group [clickOnDoneButton3] AdminSubmitAdvancedInventoryFormActionGroup");
		$I->click("//aside[contains(@class,'product_form_product_form_advanced_inventory_modal')]//button[contains(@data-role,'action')]"); // stepKey: clickOnDoneButtonClickOnDoneButton3
		$I->waitForPageLoad(5); // stepKey: clickOnDoneButtonClickOnDoneButton3WaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForProductPageToLoadClickOnDoneButton3
		$I->comment("Exiting Action Group [clickOnDoneButton3] AdminSubmitAdvancedInventoryFormActionGroup");
		$I->comment("Entering Action Group [clickOnSaveButton2] AdminProductFormSaveActionGroup");
		$I->click("#save-button"); // stepKey: saveProductClickOnSaveButton2
		$I->waitForPageLoad(30); // stepKey: saveProductClickOnSaveButton2WaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForProductSavingClickOnSaveButton2
		$I->comment("Exiting Action Group [clickOnSaveButton2] AdminProductFormSaveActionGroup");
		$I->comment("Step7. Open *Customer view* (Go to *Store Front*). Open *prod1* page (Find via search and click on product name)");
		$I->amOnPage("/" . $I->retrieveEntityField('createPreReqSimpleProduct', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: amOnProductPage
		$I->comment("Step8. Fill *1.5* in *Qty*. Click on button *Add to Cart*");
		$I->fillField("input.input-text.qty", "1.5"); // stepKey: fillQty
		$I->waitForPageLoad(30); // stepKey: fillQtyWaitForPageLoad
		$I->click("button.action.tocart.primary"); // stepKey: clickOnAddToCart
		$I->waitForPageLoad(30); // stepKey: clickOnAddToCartWaitForPageLoad
		$I->waitForElementVisible("div.message-success", 30); // stepKey: waitForProductAdded
		$I->waitForPageLoad(30); // stepKey: waitForProductAddedWaitForPageLoad
		$I->see("You added " . $I->retrieveEntityField('createPreReqSimpleProduct', 'name', 'test') . " to your shopping cart.", "div.message-success"); // stepKey: seeAddedToCartMessage
		$I->comment("Step9. Click on *Cart* icon. Click on *View and Edit Cart* link. Change *Qty* value to *5.5*");
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
		$I->fillField("//main//table[@id='shopping-cart-table']//tbody//tr[..//strong[contains(@class, 'product-item-name')]//a/text()='" . $I->retrieveEntityField('createPreReqSimpleProduct', 'name', 'test') . "'][1]//td[contains(@class, 'qty')]//input[contains(@class, 'qty')]", "5.5"); // stepKey: fillQty2
		$I->click("#form-validate button[type='submit'].update"); // stepKey: clickOnUpdateShoppingCartButton
		$I->waitForPageLoad(30); // stepKey: clickOnUpdateShoppingCartButtonWaitForPageLoad
		$I->seeInField("//main//table[@id='shopping-cart-table']//tbody//tr[..//strong[contains(@class, 'product-item-name')]//a/text()='" . $I->retrieveEntityField('createPreReqSimpleProduct', 'name', 'test') . "'][1]//td[contains(@class, 'qty')]//input[contains(@class, 'qty')]", "5.5"); // stepKey: seeInField2
	}
}
