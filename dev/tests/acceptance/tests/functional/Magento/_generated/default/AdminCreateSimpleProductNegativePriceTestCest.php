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
 * @Title("MAGETWO-89912: Admin should not be able to create a product with a negative price")
 * @Description("Admin should not be able to create a product with a negative price<h3>Test files</h3>app/code/Magento/Catalog/Test/Mftf/Test/AdminCreateSimpleProductTest/AdminCreateSimpleProductNegativePriceTest.xml<br>")
 * @TestCaseId("MAGETWO-89912")
 * @group product
 */
class AdminCreateSimpleProductNegativePriceTestCest
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
	 * @Features({"Catalog"})
	 * @Stories({"Create a Simple Product via Admin"})
	 * @Severity(level = SeverityLevel::BLOCKER)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminCreateSimpleProductNegativePriceTest(AcceptanceTester $I)
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
		$I->comment("Entering Action Group [goToCreateProduct] AdminOpenNewProductFormPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/new/set/4/type/simple/"); // stepKey: openProductNewPageGoToCreateProduct
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadGoToCreateProduct
		$I->comment("Exiting Action Group [goToCreateProduct] AdminOpenNewProductFormPageActionGroup");
		$I->comment("Comment is added to preserve the step key for backward compatibility");
		$I->comment("Comment is added to preserve the step key for backward compatibility");
		$I->comment("Entering Action Group [fillPrice] FillMainProductFormByStringActionGroup");
		$I->fillField(".admin__field[data-index=name] input", "Simple Product " . msq("SimpleProduct")); // stepKey: fillProductNameFillPrice
		$I->fillField(".admin__field[data-index=sku] input", "SimpleProduct" . msq("SimpleProduct")); // stepKey: fillProductSkuFillPrice
		$I->fillField(".admin__field[data-index=price] input", "-42"); // stepKey: fillProductPriceFillPrice
		$I->fillField(".admin__field[data-index=qty] input", "1000"); // stepKey: fillProductQtyFillPrice
		$I->selectOption("select[name='product[quantity_and_stock_status][is_in_stock]']", "1"); // stepKey: selectStockStatusFillPrice
		$I->waitForPageLoad(30); // stepKey: selectStockStatusFillPriceWaitForPageLoad
		$I->selectOption("select[name='product[product_has_weight]']", "This item has weight"); // stepKey: selectWeightFillPrice
		$I->fillField(".admin__field[data-index=weight] input", "1"); // stepKey: fillProductWeightFillPrice
		$I->comment("Exiting Action Group [fillPrice] FillMainProductFormByStringActionGroup");
		$I->comment("Entering Action Group [clickSave] AdminProductFormSaveActionGroup");
		$I->click("#save-button"); // stepKey: saveProductClickSave
		$I->waitForPageLoad(30); // stepKey: saveProductClickSaveWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForProductSavingClickSave
		$I->comment("Exiting Action Group [clickSave] AdminProductFormSaveActionGroup");
		$I->comment("Entering Action Group [seePriceValidationError] AssertAdminValidationErrorAppearedForPriceFieldOnProductEditPageActionGroup");
		$I->waitForElementVisible("//input[@name='product[price]']/parent::div/parent::div/label[@class='admin__field-error']", 30); // stepKey: waitForValidationErrorSeePriceValidationError
		$I->see("Please enter a number 0 or greater in this field.", "//input[@name='product[price]']/parent::div/parent::div/label[@class='admin__field-error']"); // stepKey: seeElementValidationErrorSeePriceValidationError
		$I->comment("Exiting Action Group [seePriceValidationError] AssertAdminValidationErrorAppearedForPriceFieldOnProductEditPageActionGroup");
	}
}
