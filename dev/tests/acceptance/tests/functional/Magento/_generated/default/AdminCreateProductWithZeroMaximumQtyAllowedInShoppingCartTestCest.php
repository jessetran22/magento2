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
 * @Title("MC-17636: Verify that product maximum qty allowed in shopping cart can't be set to zero or less")
 * @Description("Verify that product maximum qty allowed in shopping cart can't be set to zero or less<h3>Test files</h3>app/code/Magento/CatalogInventory/Test/Mftf/Test/AdminCreateProductWithZeroMaximumQtyAllowedInShoppingCartTest.xml<br>")
 * @TestCaseId("MC-17636")
 * @group catalog
 * @group catalogInventory
 */
class AdminCreateProductWithZeroMaximumQtyAllowedInShoppingCartTestCest
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
    }
	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _before(AcceptanceTester $I)
	{
		$I->createEntity("setDefaultValueForMaxSaleQty", "hook", "DefaultValueForMaxSaleQty", [], []); // stepKey: setDefaultValueForMaxSaleQty
		$I->createEntity("createdProduct", "hook", "SimpleProduct2", [], []); // stepKey: createdProduct
		$runCronIndex = $I->magentoCron("index", 90); // stepKey: runCronIndex
		$I->comment($runCronIndex);
		$I->comment("Entering Action Group [login] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLogin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLogin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLogin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLogin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLogin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLogin
		$I->comment("Exiting Action Group [login] AdminLoginActionGroup");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->createEntity("setDefaultValueForMaxSaleQty", "hook", "DefaultValueForMaxSaleQty", [], []); // stepKey: setDefaultValueForMaxSaleQty
		$I->deleteEntity("createdProduct", "hook"); // stepKey: deleteProduct
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
	 * @Features({"CatalogInventory"})
	 * @Stories({"Sales restrictions"})
	 * @Severity(level = SeverityLevel::NORMAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminCreateProductWithZeroMaximumQtyAllowedInShoppingCartTest(AcceptanceTester $I)
	{
		$I->comment("Go to Inventory configuration page");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_config/edit/section/cataloginventory/#cataloginventory_item_options-link"); // stepKey: openInventoryConfigPage
		$I->uncheckOption("#cataloginventory_item_options_max_sale_qty_inherit"); // stepKey: uncheckUseDefaultValueForMaxSaleQty
		$I->waitForPageLoad(30); // stepKey: uncheckUseDefaultValueForMaxSaleQtyWaitForPageLoad
		$I->comment("Validate zero value");
		$I->comment("Entering Action Group [validateZeroValue] AdminCatalogInventoryConfigurationMaxQtyAllowedInShoppingCartValidationActionGroup");
		$I->fillField("#cataloginventory_item_options_max_sale_qty", "0"); // stepKey: setMaxSaleQtyValueValidateZeroValue
		$I->click("#save"); // stepKey: clickSaveConfigButtonValidateZeroValue
		$I->waitForPageLoad(30); // stepKey: clickSaveConfigButtonValidateZeroValueWaitForPageLoad
		$I->waitForElementVisible("#cataloginventory_item_options_max_sale_qty-error", 30); // stepKey: waitValidationErrorMessageAppearsValidateZeroValue
		$I->see("Please enter a number greater than 0 in this field.", "#cataloginventory_item_options_max_sale_qty-error"); // stepKey: checkValidationErrorMessageValidateZeroValue
		$I->comment("Exiting Action Group [validateZeroValue] AdminCatalogInventoryConfigurationMaxQtyAllowedInShoppingCartValidationActionGroup");
		$I->comment("Validate negative value");
		$I->comment("Entering Action Group [validateNegativeValue] AdminCatalogInventoryConfigurationMaxQtyAllowedInShoppingCartValidationActionGroup");
		$I->fillField("#cataloginventory_item_options_max_sale_qty", "-1"); // stepKey: setMaxSaleQtyValueValidateNegativeValue
		$I->click("#save"); // stepKey: clickSaveConfigButtonValidateNegativeValue
		$I->waitForPageLoad(30); // stepKey: clickSaveConfigButtonValidateNegativeValueWaitForPageLoad
		$I->waitForElementVisible("#cataloginventory_item_options_max_sale_qty-error", 30); // stepKey: waitValidationErrorMessageAppearsValidateNegativeValue
		$I->see("Please enter a number greater than 0 in this field.", "#cataloginventory_item_options_max_sale_qty-error"); // stepKey: checkValidationErrorMessageValidateNegativeValue
		$I->comment("Exiting Action Group [validateNegativeValue] AdminCatalogInventoryConfigurationMaxQtyAllowedInShoppingCartValidationActionGroup");
		$I->comment("Validate alphabetical value");
		$I->comment("Entering Action Group [validateAlphabeticalValue] AdminCatalogInventoryConfigurationMaxQtyAllowedInShoppingCartValidationActionGroup");
		$I->fillField("#cataloginventory_item_options_max_sale_qty", "abc"); // stepKey: setMaxSaleQtyValueValidateAlphabeticalValue
		$I->click("#save"); // stepKey: clickSaveConfigButtonValidateAlphabeticalValue
		$I->waitForPageLoad(30); // stepKey: clickSaveConfigButtonValidateAlphabeticalValueWaitForPageLoad
		$I->waitForElementVisible("#cataloginventory_item_options_max_sale_qty-error", 30); // stepKey: waitValidationErrorMessageAppearsValidateAlphabeticalValue
		$I->see("Please enter a valid number in this field.", "#cataloginventory_item_options_max_sale_qty-error"); // stepKey: checkValidationErrorMessageValidateAlphabeticalValue
		$I->comment("Exiting Action Group [validateAlphabeticalValue] AdminCatalogInventoryConfigurationMaxQtyAllowedInShoppingCartValidationActionGroup");
		$I->comment("Fill correct value");
		$I->fillField("#cataloginventory_item_options_max_sale_qty", "100"); // stepKey: setMaxSaleQtyValueToCorrectNumber
		$I->comment("Entering Action Group [saveConfigWithCorrectNumber] AdminSaveConfigActionGroup");
		$I->click("#save"); // stepKey: clickSaveConfigBtnSaveConfigWithCorrectNumber
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitForSuccessMessageSaveConfigWithCorrectNumber
		$I->see("You saved the configuration.", "#messages div.message-success"); // stepKey: seeSuccessMessageSaveConfigWithCorrectNumber
		$I->comment("Exiting Action Group [saveConfigWithCorrectNumber] AdminSaveConfigActionGroup");
		$I->comment("Go to product page");
		$I->comment("Entering Action Group [openAdminProductEditPage] AdminProductPageOpenByIdActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/edit/id/" . $I->retrieveEntityField('createdProduct', 'id', 'test')); // stepKey: goToProductOpenAdminProductEditPage
		$I->comment("Exiting Action Group [openAdminProductEditPage] AdminProductPageOpenByIdActionGroup");
		$I->comment("Validate zero value");
		$I->comment("Entering Action Group [productValidateZeroValue] AdminProductMaxQtyAllowedInShoppingCartValidationActionGroup");
		$I->conditionalClick("button[data-index='advanced_inventory_button'].action-additional", ".product_form_product_form_advanced_inventory_modal[data-role=modal]", false); // stepKey: clickOnAdvancedInventoryLinkIfNeededProductValidateZeroValue
		$I->comment("Wait for close button appeared. That means animation finished and modal window is fully visible");
		$I->waitForElementVisible(".product_form_product_form_advanced_inventory_modal button.action-close", 30); // stepKey: waitForCloseButtonAppearedProductValidateZeroValue
		$I->waitForPageLoad(30); // stepKey: waitForCloseButtonAppearedProductValidateZeroValueWaitForPageLoad
		$I->waitForElementVisible("//*[@name='product[stock_data][use_config_max_sale_qty]']", 30); // stepKey: waitForAdvancedInventoryModalWindowOpenProductValidateZeroValue
		$I->uncheckOption("//*[@name='product[stock_data][use_config_max_sale_qty]']"); // stepKey: uncheckMaxQtyCheckBoxProductValidateZeroValue
		$I->fillField("//*[@name='product[stock_data][max_sale_qty]']", "0"); // stepKey: fillMaxAllowedQtyProductValidateZeroValue
		$I->click("//*[contains(@class, 'modal-slide') and contains(@class, '_show')]//*[contains(@class, 'page-actions')]//button[normalize-space(.)='Done']"); // stepKey: clickDoneProductValidateZeroValue
		$I->waitForPageLoad(30); // stepKey: clickDoneProductValidateZeroValueWaitForPageLoad
		$I->waitForElementVisible("[name='product[stock_data][max_sale_qty]'] + label.admin__field-error", 30); // stepKey: waitProductValidationErrorMessageAppearsProductValidateZeroValue
		$I->see("Please enter a number greater than 0 in this field.", "[name='product[stock_data][max_sale_qty]'] + label.admin__field-error"); // stepKey: checkProductValidationErrorMessageProductValidateZeroValue
		$I->comment("Exiting Action Group [productValidateZeroValue] AdminProductMaxQtyAllowedInShoppingCartValidationActionGroup");
		$I->comment("Validate negative value");
		$I->comment("Entering Action Group [productValidateNegativeValue] AdminProductMaxQtyAllowedInShoppingCartValidationActionGroup");
		$I->conditionalClick("button[data-index='advanced_inventory_button'].action-additional", ".product_form_product_form_advanced_inventory_modal[data-role=modal]", false); // stepKey: clickOnAdvancedInventoryLinkIfNeededProductValidateNegativeValue
		$I->comment("Wait for close button appeared. That means animation finished and modal window is fully visible");
		$I->waitForElementVisible(".product_form_product_form_advanced_inventory_modal button.action-close", 30); // stepKey: waitForCloseButtonAppearedProductValidateNegativeValue
		$I->waitForPageLoad(30); // stepKey: waitForCloseButtonAppearedProductValidateNegativeValueWaitForPageLoad
		$I->waitForElementVisible("//*[@name='product[stock_data][use_config_max_sale_qty]']", 30); // stepKey: waitForAdvancedInventoryModalWindowOpenProductValidateNegativeValue
		$I->uncheckOption("//*[@name='product[stock_data][use_config_max_sale_qty]']"); // stepKey: uncheckMaxQtyCheckBoxProductValidateNegativeValue
		$I->fillField("//*[@name='product[stock_data][max_sale_qty]']", "-1"); // stepKey: fillMaxAllowedQtyProductValidateNegativeValue
		$I->click("//*[contains(@class, 'modal-slide') and contains(@class, '_show')]//*[contains(@class, 'page-actions')]//button[normalize-space(.)='Done']"); // stepKey: clickDoneProductValidateNegativeValue
		$I->waitForPageLoad(30); // stepKey: clickDoneProductValidateNegativeValueWaitForPageLoad
		$I->waitForElementVisible("[name='product[stock_data][max_sale_qty]'] + label.admin__field-error", 30); // stepKey: waitProductValidationErrorMessageAppearsProductValidateNegativeValue
		$I->see("Please enter a number greater than 0 in this field.", "[name='product[stock_data][max_sale_qty]'] + label.admin__field-error"); // stepKey: checkProductValidationErrorMessageProductValidateNegativeValue
		$I->comment("Exiting Action Group [productValidateNegativeValue] AdminProductMaxQtyAllowedInShoppingCartValidationActionGroup");
		$I->comment("Validate alphabetical value");
		$I->comment("Entering Action Group [productValidateAlphabeticalValue] AdminProductMaxQtyAllowedInShoppingCartValidationActionGroup");
		$I->conditionalClick("button[data-index='advanced_inventory_button'].action-additional", ".product_form_product_form_advanced_inventory_modal[data-role=modal]", false); // stepKey: clickOnAdvancedInventoryLinkIfNeededProductValidateAlphabeticalValue
		$I->comment("Wait for close button appeared. That means animation finished and modal window is fully visible");
		$I->waitForElementVisible(".product_form_product_form_advanced_inventory_modal button.action-close", 30); // stepKey: waitForCloseButtonAppearedProductValidateAlphabeticalValue
		$I->waitForPageLoad(30); // stepKey: waitForCloseButtonAppearedProductValidateAlphabeticalValueWaitForPageLoad
		$I->waitForElementVisible("//*[@name='product[stock_data][use_config_max_sale_qty]']", 30); // stepKey: waitForAdvancedInventoryModalWindowOpenProductValidateAlphabeticalValue
		$I->uncheckOption("//*[@name='product[stock_data][use_config_max_sale_qty]']"); // stepKey: uncheckMaxQtyCheckBoxProductValidateAlphabeticalValue
		$I->fillField("//*[@name='product[stock_data][max_sale_qty]']", "abc"); // stepKey: fillMaxAllowedQtyProductValidateAlphabeticalValue
		$I->click("//*[contains(@class, 'modal-slide') and contains(@class, '_show')]//*[contains(@class, 'page-actions')]//button[normalize-space(.)='Done']"); // stepKey: clickDoneProductValidateAlphabeticalValue
		$I->waitForPageLoad(30); // stepKey: clickDoneProductValidateAlphabeticalValueWaitForPageLoad
		$I->waitForElementVisible("[name='product[stock_data][max_sale_qty]'] + label.admin__field-error", 30); // stepKey: waitProductValidationErrorMessageAppearsProductValidateAlphabeticalValue
		$I->see("Please enter a valid number in this field.", "[name='product[stock_data][max_sale_qty]'] + label.admin__field-error"); // stepKey: checkProductValidationErrorMessageProductValidateAlphabeticalValue
		$I->comment("Exiting Action Group [productValidateAlphabeticalValue] AdminProductMaxQtyAllowedInShoppingCartValidationActionGroup");
		$I->comment("Fill correct value");
		$I->comment("Entering Action Group [setProductMaxQtyAllowedInShoppingCartToCorrectNumber] AdminProductSetMaxQtyAllowedInShoppingCartActionGroup");
		$I->conditionalClick("button[data-index='advanced_inventory_button'].action-additional", ".product_form_product_form_advanced_inventory_modal[data-role=modal]", false); // stepKey: clickOnAdvancedInventoryLinkIfNeededSetProductMaxQtyAllowedInShoppingCartToCorrectNumber
		$I->comment("Wait for close button appeared. That means animation finished and modal window is fully visible");
		$I->waitForElementVisible(".product_form_product_form_advanced_inventory_modal button.action-close", 30); // stepKey: waitForCloseButtonAppearedSetProductMaxQtyAllowedInShoppingCartToCorrectNumber
		$I->waitForPageLoad(30); // stepKey: waitForCloseButtonAppearedSetProductMaxQtyAllowedInShoppingCartToCorrectNumberWaitForPageLoad
		$I->waitForElementVisible("//*[@name='product[stock_data][use_config_max_sale_qty]']", 30); // stepKey: waitForAdvancedInventoryModalWindowOpenSetProductMaxQtyAllowedInShoppingCartToCorrectNumber
		$I->uncheckOption("//*[@name='product[stock_data][use_config_max_sale_qty]']"); // stepKey: uncheckMaxQtyCheckBoxSetProductMaxQtyAllowedInShoppingCartToCorrectNumber
		$I->fillField("//*[@name='product[stock_data][max_sale_qty]']", "50"); // stepKey: fillMaxAllowedQtySetProductMaxQtyAllowedInShoppingCartToCorrectNumber
		$I->click("//*[contains(@class, 'modal-slide') and contains(@class, '_show')]//*[contains(@class, 'page-actions')]//button[normalize-space(.)='Done']"); // stepKey: clickDoneSetProductMaxQtyAllowedInShoppingCartToCorrectNumber
		$I->waitForPageLoad(30); // stepKey: clickDoneSetProductMaxQtyAllowedInShoppingCartToCorrectNumberWaitForPageLoad
		$I->comment("Exiting Action Group [setProductMaxQtyAllowedInShoppingCartToCorrectNumber] AdminProductSetMaxQtyAllowedInShoppingCartActionGroup");
		$I->waitForElementNotVisible(".product_form_product_form_advanced_inventory_modal[data-role=modal]", 30); // stepKey: waitForModalFormToDisappear
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
	}
}
