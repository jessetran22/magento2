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
 * @Title("[NO TESTCASEID]: Check that added image for created product has selected image roles.")
 * @Description("Login as admin, create simple product, add image to created product (via API).Go to                 Admin Product Edit page for created product to check that added image has selected image roles.<h3>Test files</h3>app/code/Magento/Catalog/Test/Mftf/Test/AdminCheckMediaRolesForFirstAddedImageViaApiTest.xml<br>")
 * @group catalog
 */
class AdminCheckMediaRolesForFirstAddedImageViaApiTestCest
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
		$I->comment("Entering Action Group [loginToAdminPanel] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginToAdminPanel
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginToAdminPanel
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginToAdminPanel
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginToAdminPanel
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginToAdminPanelWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginToAdminPanel
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginToAdminPanel
		$I->comment("Exiting Action Group [loginToAdminPanel] AdminLoginActionGroup");
		$I->createEntity("createSimpleProduct", "hook", "SimpleOutOfStockProduct", [], []); // stepKey: createSimpleProduct
		$I->createEntity("createSimpleProductImage", "hook", "ApiProductAttributeMediaGalleryEntryWithoutTypesTestImage", ["createSimpleProduct"], []); // stepKey: createSimpleProductImage
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->deleteEntity("createSimpleProduct", "hook"); // stepKey: deleteSimpleProduct
		$I->comment("Entering Action Group [logout] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageLogout
		$I->comment("Exiting Action Group [logout] AdminLogoutActionGroup");
		$I->comment("Reindex invalidated indices after product attribute has been created/deleted");
		$reindexInvalidatedIndices = $I->magentoCron("index", 90); // stepKey: reindexInvalidatedIndices
		$I->comment($reindexInvalidatedIndices);
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
	 * @Stories({"Add Simple Product with image via API"})
	 * @Severity(level = SeverityLevel::NORMAL)
	 * @Features({"Catalog"})
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminCheckMediaRolesForFirstAddedImageViaApiTest(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [goToSimpleProduct] AdminProductPageOpenByIdActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/edit/id/" . $I->retrieveEntityField('createSimpleProduct', 'id', 'test')); // stepKey: goToProductGoToSimpleProduct
		$I->comment("Exiting Action Group [goToSimpleProduct] AdminProductPageOpenByIdActionGroup");
		$I->comment("Entering Action Group [openProductImagesSection] AdminOpenProductImagesSectionActionGroup");
		$I->conditionalClick("div[data-index=gallery] .admin__collapsible-title", "div.image div.fileinput-button", false); // stepKey: openProductImagesSectionOpenProductImagesSection
		$I->scrollTo("div[data-index=gallery] .admin__collapsible-title"); // stepKey: scrollToProductImagesSectionOpenProductImagesSection
		$I->waitForPageLoad(30); // stepKey: waitForLoadingMediaContentOpenProductImagesSection
		$I->waitForElementVisible("div.image div.fileinput-button", 30); // stepKey: waitForImageUploadButtonOpenProductImagesSection
		$I->comment("Exiting Action Group [openProductImagesSection] AdminOpenProductImagesSectionActionGroup");
		$I->comment("Entering Action Group [checkImageRolesSelected] AssertAdminProductImageRolesSelectedActionGroup");
		$I->waitForElementVisible("//*[@id='media_gallery_content']//img[contains(@src, '" . $I->retrieveEntityField('createSimpleProductImage', 'entry[content][name]', 'test') . "')]", 30); // stepKey: seeProductImageNameCheckImageRolesSelected
		$I->click("//*[@id='media_gallery_content']//img[contains(@src, '" . $I->retrieveEntityField('createSimpleProductImage', 'entry[content][name]', 'test') . "')]"); // stepKey: clickProductImageCheckImageRolesSelected
		$I->waitForElementVisible("//div[contains(@class, 'field-image-role')]//ul/li[contains(@class, 'selected')]/label[normalize-space(.) = 'Base']", 30); // stepKey: checkRoleBaseSelectedCheckImageRolesSelected
		$I->waitForElementVisible("//div[contains(@class, 'field-image-role')]//ul/li[contains(@class, 'selected')]/label[normalize-space(.) = 'Small']", 30); // stepKey: checkRoleSmallSelectedCheckImageRolesSelected
		$I->waitForElementVisible("//div[contains(@class, 'field-image-role')]//ul/li[contains(@class, 'selected')]/label[normalize-space(.) = 'Thumbnail']", 30); // stepKey: checkRoleThumbnailSelectedCheckImageRolesSelected
		$I->waitForElementVisible("//div[contains(@class, 'field-image-role')]//ul/li[contains(@class, 'selected')]/label[normalize-space(.) = 'Swatch']", 30); // stepKey: checkRoleSwatchSelectedCheckImageRolesSelected
		$I->comment("Exiting Action Group [checkImageRolesSelected] AssertAdminProductImageRolesSelectedActionGroup");
	}
}
