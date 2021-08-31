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
 * @Title("MC-112: Admin should see an error when trying to save a product with a duplicate URL key")
 * @Description("Admin should see an error when trying to save a product with a duplicate URL key<h3>Test files</h3>app/code/Magento/Catalog/Test/Mftf/Test/AdminCreateProductDuplicateUrlkeyTest/AdminCreateProductDuplicateUrlkeyTest.xml<br>")
 * @TestCaseId("MC-112")
 * @group product
 */
class AdminCreateProductDuplicateUrlkeyTestCest
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
		$I->createEntity("simpleProduct", "hook", "SimpleTwo", [], []); // stepKey: simpleProduct
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [adminLogout] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageAdminLogout
		$I->comment("Exiting Action Group [adminLogout] AdminLogoutActionGroup");
		$I->deleteEntity("simpleProduct", "hook"); // stepKey: deleteProduct
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
	 * @Stories({"Errors"})
	 * @Severity(level = SeverityLevel::NORMAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminCreateProductDuplicateUrlkeyTest(AcceptanceTester $I)
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
		$I->comment("Entering Action Group [navigateToProductIndex] AdminOpenProductIndexPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: goToProductIndexPageNavigateToProductIndex
		$I->waitForPageLoad(30); // stepKey: waitForProductIndexPageLoadNavigateToProductIndex
		$I->comment("Exiting Action Group [navigateToProductIndex] AdminOpenProductIndexPageActionGroup");
		$I->comment("Adding the comment to replace clickAddProductToggle action for preserving Backward Compatibility");
		$I->comment("Entering Action Group [clickAddSimpleProduct] AdminClickAddProductToggleAndSelectProductTypeActionGroup");
		$I->click(".action-toggle.primary.add"); // stepKey: clickAddProductDropdownClickAddSimpleProduct
		$I->waitForPageLoad(30); // stepKey: clickAddProductDropdownClickAddSimpleProductWaitForPageLoad
		$I->click(".item[data-ui-id='products-list-add-new-product-button-item-simple']"); // stepKey: clickAddProductClickAddSimpleProduct
		$I->waitForPageLoad(30); // stepKey: waitForFormToLoadClickAddSimpleProduct
		$I->comment("Exiting Action Group [clickAddSimpleProduct] AdminClickAddProductToggleAndSelectProductTypeActionGroup");
		$I->comment("Entering Action Group [fillName] AdminFillProductNameOnProductFormActionGroup");
		$I->fillField(".admin__field[data-index=name] input", $I->retrieveEntityField('simpleProduct', 'name', 'test') . "new"); // stepKey: fillProductNameFillName
		$I->comment("Exiting Action Group [fillName] AdminFillProductNameOnProductFormActionGroup");
		$I->comment("Entering Action Group [fillSKU] AdminFillProductSkuOnProductFormActionGroup");
		$I->fillField(".admin__field[data-index=sku] input", $I->retrieveEntityField('simpleProduct', 'sku', 'test') . "new"); // stepKey: fillProductSkuFillSKU
		$I->comment("Exiting Action Group [fillSKU] AdminFillProductSkuOnProductFormActionGroup");
		$I->comment("Entering Action Group [fillPrice] AdminFillProductPriceFieldAndPressEnterOnProductEditPageActionGroup");
		$I->waitForElementVisible(".admin__field[data-index=price] input", 30); // stepKey: waitForPriceFieldFillPrice
		$I->fillField(".admin__field[data-index=price] input", $I->retrieveEntityField('simpleProduct', 'price', 'test')); // stepKey: fillPriceFieldFillPrice
		$I->pressKey(".admin__field[data-index=price] input", \Facebook\WebDriver\WebDriverKeys::ENTER); // stepKey: pressEnterButtonFillPrice
		$I->comment("Exiting Action Group [fillPrice] AdminFillProductPriceFieldAndPressEnterOnProductEditPageActionGroup");
		$I->comment("Entering Action Group [fillQuantity] AdminFillProductQtyOnProductFormActionGroup");
		$I->fillField(".admin__field[data-index=qty] input", $I->retrieveEntityField('simpleProduct', 'quantity', 'test')); // stepKey: fillProductQtyFillQuantity
		$I->comment("Exiting Action Group [fillQuantity] AdminFillProductQtyOnProductFormActionGroup");
		$I->click("div[data-index='search-engine-optimization']"); // stepKey: openSeoSection
		$I->waitForPageLoad(30); // stepKey: openSeoSectionWaitForPageLoad
		$I->fillField("input[name='product[url_key]']", $I->retrieveEntityField('simpleProduct', 'custom_attributes[url_key]', 'test')); // stepKey: fillUrlKey
		$I->comment("Entering Action Group [saveProduct] AdminProductFormSaveActionGroup");
		$I->click("#save-button"); // stepKey: saveProductSaveProduct
		$I->waitForPageLoad(30); // stepKey: saveProductSaveProductWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForProductSavingSaveProduct
		$I->comment("Exiting Action Group [saveProduct] AdminProductFormSaveActionGroup");
		$I->comment("Entering Action Group [assertErrorMessage] AssertMessageInAdminPanelActionGroup");
		$I->waitForElementVisible("#messages div.message-error", 30); // stepKey: waitForMessageVisibleAssertErrorMessage
		$I->see("The value specified in the URL Key field would generate a URL that already exists", "#messages div.message-error"); // stepKey: verifyMessageAssertErrorMessage
		$I->comment("Exiting Action Group [assertErrorMessage] AssertMessageInAdminPanelActionGroup");
	}
}
