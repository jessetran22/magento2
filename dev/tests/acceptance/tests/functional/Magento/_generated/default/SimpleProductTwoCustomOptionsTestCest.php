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
 * @Title("MC-248: Admin should be able to create simple product with two custom options")
 * @Description("Admin should be able to create simple product with two custom options<h3>Test files</h3>app/code/Magento/Catalog/Test/Mftf/Test/SimpleProductTwoCustomOptionsTest.xml<br>")
 * @TestCaseId("MC-248")
 * @group Catalog
 */
class SimpleProductTwoCustomOptionsTestCest
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
		$I->comment("log in as admin");
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
		$I->comment("Entering Action Group [navigateToProductIndex] AdminOpenProductIndexPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: goToProductIndexPageNavigateToProductIndex
		$I->waitForPageLoad(30); // stepKey: waitForProductIndexPageLoadNavigateToProductIndex
		$I->comment("Exiting Action Group [navigateToProductIndex] AdminOpenProductIndexPageActionGroup");
		$I->comment("Entering Action Group [goToCreateSimpleProduct] GoToCreateProductPageActionGroup");
		$I->click(".action-toggle.primary.add"); // stepKey: clickAddProductToggleGoToCreateSimpleProduct
		$I->waitForPageLoad(30); // stepKey: clickAddProductToggleGoToCreateSimpleProductWaitForPageLoad
		$I->waitForElementVisible(".item[data-ui-id='products-list-add-new-product-button-item-simple']", 30); // stepKey: waitForAddProductDropdownGoToCreateSimpleProduct
		$I->click(".item[data-ui-id='products-list-add-new-product-button-item-simple']"); // stepKey: clickAddProductTypeGoToCreateSimpleProduct
		$I->waitForPageLoad(30); // stepKey: waitForCreateProductPageLoadGoToCreateSimpleProduct
		$I->seeInCurrentUrl((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/new/set/4/type/simple/"); // stepKey: seeNewProductUrlGoToCreateSimpleProduct
		$I->see("New Product", ".page-header h1.page-title"); // stepKey: seeNewProductTitleGoToCreateSimpleProduct
		$I->comment("Exiting Action Group [goToCreateSimpleProduct] GoToCreateProductPageActionGroup");
		$I->comment("Entering Action Group [fillSimpleProductMain] FillMainProductFormNoWeightActionGroup");
		$I->fillField(".admin__field[data-index=name] input", "Simple Product 3 " . msq("SimpleProduct3")); // stepKey: fillProductNameFillSimpleProductMain
		$I->fillField(".admin__field[data-index=sku] input", "SimpleProduct3" . msq("SimpleProduct3")); // stepKey: fillProductSkuFillSimpleProductMain
		$I->fillField(".admin__field[data-index=price] input", "123.00"); // stepKey: fillProductPriceFillSimpleProductMain
		$I->fillField(".admin__field[data-index=qty] input", "1000"); // stepKey: fillProductQtyFillSimpleProductMain
		$I->selectOption("select[name='product[quantity_and_stock_status][is_in_stock]']", "1"); // stepKey: selectStockStatusFillSimpleProductMain
		$I->waitForPageLoad(30); // stepKey: selectStockStatusFillSimpleProductMainWaitForPageLoad
		$I->selectOption("select[name='product[product_has_weight]']", "This item has no weight"); // stepKey: selectWeightFillSimpleProductMain
		$I->comment("Exiting Action Group [fillSimpleProductMain] FillMainProductFormNoWeightActionGroup");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Delete the created product");
		$I->comment("Entering Action Group [deleteProduct] DeleteProductUsingProductGridActionGroup");
		$I->comment("TODO use other action group for filtering grid when MQE-539 is implemented");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: visitAdminProductPageDeleteProduct
		$I->waitForPageLoad(60); // stepKey: waitForPageLoadInitialDeleteProduct
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersInitialDeleteProduct
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersInitialDeleteProductWaitForPageLoad
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openProductFiltersDeleteProduct
		$I->fillField("input.admin__control-text[name='sku']", "SimpleProduct3" . msq("SimpleProduct3")); // stepKey: fillProductSkuFilterDeleteProduct
		$I->fillField("input.admin__control-text[name='name']", "Simple Product 3 " . msq("SimpleProduct3")); // stepKey: fillProductNameFilterDeleteProduct
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersDeleteProduct
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersDeleteProductWaitForPageLoad
		$I->see("SimpleProduct3" . msq("SimpleProduct3"), "//tr[1]//td[count(//div[@data-role='grid-wrapper']//tr//th[normalize-space(.)='SKU']/preceding-sibling::th) +1 ]"); // stepKey: seeProductSkuInGridDeleteProduct
		$I->click("div[data-role='grid-wrapper'] th.data-grid-multicheck-cell button.action-multicheck-toggle"); // stepKey: openMulticheckDropdownDeleteProduct
		$I->click("//div[@data-role='grid-wrapper']//th[contains(@class, data-grid-multicheck-cell)]//li//span[text() = 'Select All']"); // stepKey: selectAllProductInFilteredGridDeleteProduct
		$I->click("div.admin__data-grid-header-row.row div.action-select-wrap button.action-select"); // stepKey: clickActionDropdownDeleteProduct
		$I->waitForPageLoad(30); // stepKey: clickActionDropdownDeleteProductWaitForPageLoad
		$I->click("//div[contains(@class,'admin__data-grid-header-row') and contains(@class, 'row')]//div[contains(@class, 'action-select-wrap')]//ul/li/span[text() = 'Delete']"); // stepKey: clickDeleteActionDeleteProduct
		$I->waitForPageLoad(30); // stepKey: clickDeleteActionDeleteProductWaitForPageLoad
		$I->waitForElementVisible(".modal-popup.confirm h1.modal-title", 30); // stepKey: waitForConfirmModalDeleteProduct
		$I->click(".modal-popup.confirm button.action-accept"); // stepKey: confirmProductDeleteDeleteProduct
		$I->waitForPageLoad(60); // stepKey: confirmProductDeleteDeleteProductWaitForPageLoad
		$I->comment("Exiting Action Group [deleteProduct] DeleteProductUsingProductGridActionGroup");
		$I->comment("Entering Action Group [amOnLogoutPage] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageAmOnLogoutPage
		$I->comment("Exiting Action Group [amOnLogoutPage] AdminLogoutActionGroup");
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
	 * @Stories({"Create simple product with two custom options"})
	 * @Severity(level = SeverityLevel::BLOCKER)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function SimpleProductTwoCustomOptionsTest(AcceptanceTester $I)
	{
		$I->comment("opens the custom option panel and clicks add options");
		$I->click("//strong[contains(@class, 'admin__collapsible-title')]/span[text()='Customizable Options']"); // stepKey: openCustomizableOptions
		$I->waitForPageLoad(30); // stepKey: waitForCustomOptionsOpen
		$I->comment("Create a custom option with 2 values");
		$I->comment("Entering Action Group [createCustomOption1] CreateCustomRadioOptionsActionGroup");
		$I->comment("ActionGroup will add a single custom option to a product");
		$I->comment("You must already be on the product creation page");
		$I->click("button[data-index='button_add']"); // stepKey: clickAddOptionsCreateCustomOption1
		$I->waitForPageLoad(30); // stepKey: clickAddOptionsCreateCustomOption1WaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForAddProductPageLoadCreateCustomOption1
		$I->comment("Fill in the option and select the type of radio (once)");
		$I->fillField("//*[@data-index='custom_options']//*[@data-index='options']/tbody/tr[last()]//*[contains(@class, '_required')]//input", "OptionRadioButtons"); // stepKey: fillInOptionTitleCreateCustomOption1
		$I->click("//*[@data-index='custom_options']//*[@data-index='options']/tbody/tr[last()]//*[contains(@class, 'admin__action-multiselect-text')]"); // stepKey: clickOptionTypeParentCreateCustomOption1
		$I->waitForPageLoad(30); // stepKey: waitForDropdownOpenCreateCustomOption1
		$I->click("//*[@data-index='custom_options']//label[text()='Radio Buttons'][ancestor::*[contains(@class, '_active')]]"); // stepKey: clickOptionTypeCreateCustomOption1
		$I->comment("Add three radio options based on the parameter");
		$I->click("//*[@data-index='custom_options']//*[@data-index='options']/tbody/tr[last()]//*[@data-action='add_new_row']"); // stepKey: clickAddValueCreateCustomOption1
		$I->waitForPageLoad(30); // stepKey: clickAddValueCreateCustomOption1WaitForPageLoad
		$I->fillField("//*[@data-index='custom_options']//*[@data-index='options']/tbody/tr[last()]//*[contains(@class, 'admin__control-table')]//tbody/tr[last()]//*[@data-index='title']//input", "OptionField"); // stepKey: fillInValueTitleCreateCustomOption1
		$I->fillField("//*[@data-index='custom_options']//*[@data-index='options']/tbody/tr[last()]//*[contains(@class, 'admin__control-table')]//tbody/tr[last()]//*[@data-index='price']//input", "10"); // stepKey: fillInValuePriceCreateCustomOption1
		$I->click("//*[@data-index='custom_options']//*[@data-index='options']/tbody/tr[last()]//*[@data-action='add_new_row']"); // stepKey: clickAddValue2CreateCustomOption1
		$I->waitForPageLoad(30); // stepKey: clickAddValue2CreateCustomOption1WaitForPageLoad
		$I->fillField("//*[@data-index='custom_options']//*[@data-index='options']/tbody/tr[last()]//*[contains(@class, 'admin__control-table')]//tbody/tr[last()]//*[@data-index='title']//input", "OptionField2"); // stepKey: fillInValueTitle2CreateCustomOption1
		$I->fillField("//*[@data-index='custom_options']//*[@data-index='options']/tbody/tr[last()]//*[contains(@class, 'admin__control-table')]//tbody/tr[last()]//*[@data-index='price']//input", "20"); // stepKey: fillInValuePrice2CreateCustomOption1
		$I->comment("Exiting Action Group [createCustomOption1] CreateCustomRadioOptionsActionGroup");
		$I->comment("Create another custom option with 2 values");
		$I->comment("Entering Action Group [createCustomOption2] CreateCustomRadioOptionsActionGroup");
		$I->comment("ActionGroup will add a single custom option to a product");
		$I->comment("You must already be on the product creation page");
		$I->click("button[data-index='button_add']"); // stepKey: clickAddOptionsCreateCustomOption2
		$I->waitForPageLoad(30); // stepKey: clickAddOptionsCreateCustomOption2WaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForAddProductPageLoadCreateCustomOption2
		$I->comment("Fill in the option and select the type of radio (once)");
		$I->fillField("//*[@data-index='custom_options']//*[@data-index='options']/tbody/tr[last()]//*[contains(@class, '_required')]//input", "OptionRadioButtons"); // stepKey: fillInOptionTitleCreateCustomOption2
		$I->click("//*[@data-index='custom_options']//*[@data-index='options']/tbody/tr[last()]//*[contains(@class, 'admin__action-multiselect-text')]"); // stepKey: clickOptionTypeParentCreateCustomOption2
		$I->waitForPageLoad(30); // stepKey: waitForDropdownOpenCreateCustomOption2
		$I->click("//*[@data-index='custom_options']//label[text()='Radio Buttons'][ancestor::*[contains(@class, '_active')]]"); // stepKey: clickOptionTypeCreateCustomOption2
		$I->comment("Add three radio options based on the parameter");
		$I->click("//*[@data-index='custom_options']//*[@data-index='options']/tbody/tr[last()]//*[@data-action='add_new_row']"); // stepKey: clickAddValueCreateCustomOption2
		$I->waitForPageLoad(30); // stepKey: clickAddValueCreateCustomOption2WaitForPageLoad
		$I->fillField("//*[@data-index='custom_options']//*[@data-index='options']/tbody/tr[last()]//*[contains(@class, 'admin__control-table')]//tbody/tr[last()]//*[@data-index='title']//input", "OptionField"); // stepKey: fillInValueTitleCreateCustomOption2
		$I->fillField("//*[@data-index='custom_options']//*[@data-index='options']/tbody/tr[last()]//*[contains(@class, 'admin__control-table')]//tbody/tr[last()]//*[@data-index='price']//input", "10"); // stepKey: fillInValuePriceCreateCustomOption2
		$I->click("//*[@data-index='custom_options']//*[@data-index='options']/tbody/tr[last()]//*[@data-action='add_new_row']"); // stepKey: clickAddValue2CreateCustomOption2
		$I->waitForPageLoad(30); // stepKey: clickAddValue2CreateCustomOption2WaitForPageLoad
		$I->fillField("//*[@data-index='custom_options']//*[@data-index='options']/tbody/tr[last()]//*[contains(@class, 'admin__control-table')]//tbody/tr[last()]//*[@data-index='title']//input", "OptionField2"); // stepKey: fillInValueTitle2CreateCustomOption2
		$I->fillField("//*[@data-index='custom_options']//*[@data-index='options']/tbody/tr[last()]//*[contains(@class, 'admin__control-table')]//tbody/tr[last()]//*[@data-index='price']//input", "20"); // stepKey: fillInValuePrice2CreateCustomOption2
		$I->comment("Exiting Action Group [createCustomOption2] CreateCustomRadioOptionsActionGroup");
		$I->comment("Save the product");
		$I->click("#save-button"); // stepKey: saveProduct
		$I->waitForPageLoad(30); // stepKey: saveProductWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForProductSaved
		$I->seeElement(".message-success"); // stepKey: assertSuccess
		$I->comment("navigate to the created product page");
		$I->amOnPage("/simple-product-3-" . msq("SimpleProduct3") . ".html"); // stepKey: goToCreatedProduct
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoad
		$I->comment("Check to make sure all of the created names are there");
		$I->see("OptionField", "//*[@id='product-options-wrapper']/*[@class='fieldset']/*[contains(@class, 'field')][1]"); // stepKey: assertNameInFirstOption
		$I->see("OptionField", "//*[@id='product-options-wrapper']/*[@class='fieldset']/*[contains(@class, 'field')][2]"); // stepKey: assertNameInSecondOption
		$I->see("OptionField2", "//*[@id='product-options-wrapper']/*[@class='fieldset']/*[contains(@class, 'field')][1]"); // stepKey: assertSecondNameInFirstOption
		$I->see("OptionField2", "//*[@id='product-options-wrapper']/*[@class='fieldset']/*[contains(@class, 'field')][2]"); // stepKey: assertSecondNameInSecondOption
		$I->comment("Check to see that all of the created prices are there");
		$I->see("10", "//*[@id='product-options-wrapper']/*[@class='fieldset']/*[contains(@class, 'field')][1]"); // stepKey: assertPriceInFirstOption
		$I->see("10", "//*[@id='product-options-wrapper']/*[@class='fieldset']/*[contains(@class, 'field')][2]"); // stepKey: assertPriceInSecondOption
		$I->see("20", "//*[@id='product-options-wrapper']/*[@class='fieldset']/*[contains(@class, 'field')][1]"); // stepKey: assertSecondPriceInFirstOption
		$I->see("20", "//*[@id='product-options-wrapper']/*[@class='fieldset']/*[contains(@class, 'field')][2]"); // stepKey: assertSecondPriceInSecondOption
		$I->comment("select two of the radio buttons");
		$I->click("//*[@id='product-options-wrapper']/*[@class='fieldset']/*[contains(@class, 'field')][1]//*[contains(@class, 'admin__field-option')][2]//input"); // stepKey: selectFirstCustomOption
		$I->click("//*[@id='product-options-wrapper']/*[@class='fieldset']/*[contains(@class, 'field')][2]//*[contains(@class, 'admin__field-option')][1]//input"); // stepKey: selectSecondCustomOption
		$I->comment("Check that the price has actually changed");
		$I->see("153.00", "div.price-box.price-final_price"); // stepKey: assertPriceHasChanged
	}
}
